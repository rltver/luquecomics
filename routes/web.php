<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CharactersController;
use App\Http\Controllers\ComicCommentController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Models\Comic;
use App\Models\OrderItem;
use App\Models\Publisher;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
//    $comics = Comic::where('stock', '>', 0)->orderBy('stock', 'asc')->take(8)->get(); // comics with less stock without beaing 0

    //get the ids of the best sold comics
    $topComicIds = OrderItem::select('comic_id', DB::raw('SUM(quantity) as total_sold'))
        ->groupBy('comic_id')
        ->orderByDesc('total_sold')
        ->take(8)
        ->pluck('comic_id');


// get the comics with the ids
    $comics = Comic::whereIn('id', $topComicIds)
        ->where('stock','>',0)
        ->get()
        ->sortBy(function ($comic) use ($topComicIds) {
        return array_search($comic->id, $topComicIds->toArray());
    });;

    //if there are not 8 different comics sold we need to fill it with other (latest)
    if ($comics->count() < 8) {
        $remaining = 8 - $comics->count();

        $fillerComics = Comic::whereNotIn('id', $comics->pluck('id'))
            ->where('stock','>',0)
            ->latest()
            ->take($remaining)
            ->get();

        $comics = $comics->concat($fillerComics);
    }

    return view('welcome', compact('comics'));
})->name('home');

Route::get('/email/verify', function () {
    if (auth()->user()->hasVerifiedEmail()) {
        return redirect('/');
    }
    return view('auth.verify-email'); // crea esta vista si no existe
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // marca el email como verificado
    return redirect('/')->with('success',__('notifications.verified')); // o a donde quieras redirigir
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', __('notifications.verification'));
})->middleware(['auth', 'throttle:30,1'])->name('verification.send');

Route::controller(RegisterController::class)->middleware('guest')->group(function () {
    Route::get('/register', 'create')->name('register.create');
    Route::post('/register', 'store')->name('register.store');
});

Route::get('/language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    session(['locale' => $locale]);
    return redirect()->back();
})->name('language.switch');

Route::controller(SessionController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'create')->name('login');
        Route::post('/login', 'store')->name('session.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/my-orders', 'orders')->name('session.orders');
        Route::get('/account-info', 'accountInfo')->name('session.accountInfo');
        Route::post('/logout', 'destroy')->name('session.destroy');
    });

    Route::middleware(['auth','admin'])->group(function () {
        Route::get('/add-comic', 'addComic')->name('session.addComic');
        Route::get('/edit-comic/{comic}', 'editComic')->name('session.editComic');
        Route::post('/store-comic', 'storeComic')->name('session.storeComic');
        Route::put('/update-comic/{comic}', 'updateComic')->name('session.updateComic');
        Route::put('/update-thumbnail/{comic}', 'updateThumbnail')->name('session.updateThumbnail');
        Route::delete('/delete-comic/{comic}', 'deleteComic')->name('session.deleteComic');
    });
});

Route::controller(CartController::class)->group(function () {
    Route::get('/add-to-cart/{comic}', 'add')->name('cart.add');
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart-update', 'update')->name('cart.update');
    Route::put('/cart', 'unsetComic')->name('cart.removeFromCart');

    Route::middleware(['auth','verified'])->group(function () {
        Route::get('/confirm-order', 'confirmOrder')->name('cart.confirmOrder');
        Route::post('/place-order', 'placeOrder')->name('cart.placeOrder');
        Route::get('/order-success', 'orderSuccess')->name('cart.orderSuccess');
    });

});


Route::controller(ComicController::class)->group(function () {
    Route::get('/comics', 'index')->name('comics.index');
    Route::get('/comics/{comic}', 'show')->name('comics.show');
});

Route::controller(ComicCommentController::class)->middleware('auth')->group(function () {
    Route::post('/comics/{comic}/comments', 'store')->name('comments.store');
});

Route::controller(CharactersController::class)->group(function () {
    Route::get('/characters', 'index')->name('characters.index');
    Route::get('/characters/{character}', 'show')->name('characters.show');

    Route::middleware(['auth','admin'])->group(function () {
        Route::get('/add-character', 'create')->name('characters.create');
        Route::get('/edit-character/{character}', 'edit')->name('characters.edit');
        Route::post('/store-character', 'store')->name('characters.store');
        Route::put('/update-character/{character}', 'update')->name('characters.update');
        Route::put('/update-character-thumbnail/{character}', 'updateImage')->name('characters.updateImage');
        Route::delete('/delete-character/{character}', 'destroy')->name('characters.destroy');
    });
});

Route::controller(PublisherController::class)->group(function () {
    Route::get('/publishers/{publisher}', 'show')->name('publishers.show');

    Route::middleware(['auth','admin'])->group(function () {
        Route::get('/add-publisher', 'create')->name('publishers.create');
        Route::get('/edit-publisher/{publisher}', 'edit')->name('publishers.edit');
        Route::post('/store-publisher', 'store')->name('publishers.store');
        Route::put('/update-publisher/{publisher}', 'update')->name('publishers.update');
        Route::put('/update-publisher-thumbnail/{publisher}', 'updateImage')->name('publishers.updateImage');
        Route::delete('/delete-publisher/{publisher}', 'destroy')->name('publishers.destroy');
    });
});
