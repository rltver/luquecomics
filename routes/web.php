<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ComicCommentController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/verify', function () {
    if (auth()->user()->hasVerifiedEmail()) {
        return redirect('/');
    }
    return view('auth.verify-email'); // crea esta vista si no existe
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // marca el email como verificado
    return redirect('/')->with('success','¡Correo Verificado!'); // o a donde quieras redirigir
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', '¡Correo de verificación enviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

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

//Route::controller(SessionController::class)->group(function () {
//    Route::get('/login', 'create')->name('session.create');
//    Route::get('/my-orders', 'orders')->name('session.orders');
//    Route::get('/account-info', 'accountInfo')->name('session.accountInfo');
//    Route::post('/login', 'store')->name('session.store');
//    Route::post('/logout', 'destroy')->name('session.destroy');
//});

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
        Route::get('/edit-comic', 'editComic')->name('session.editComic');
        Route::post('/store-comic', 'storeComic')->name('session.storeComic');
        Route::post('/update-comic', 'updateComic')->name('session.updateComic');
        Route::delete('/delete-comic', 'deleteComic')->name('session.deleteComic');
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
//    Route::get('/tasks', 'index')->name('tasks.index');
//    Route::get('/tasks/deletedTasks', 'deletedTasks')->name('tasks.deletedTasks');
//    Route::get('/tasks/create', 'create')->name('tasks.create');
//    Route::get('/tasks/{task}', 'show')->name('tasks.show');
//    Route::post('/tasks', 'store')->name('tasks.store');
//    Route::get('/tasks/{task}/edit', 'edit')->name('tasks.edit');
//    Route::patch('/tasks/{task}', 'update')->name('tasks.update');
//    Route::delete('/tasks/{task}', 'destroy')->name('tasks.destroy');
//    Route::post('/tasks/restore/{task}', 'restore')->name('tasks.restore');
//    Route::delete('/tasks/forceDelete/{task}', 'forceDelete')->name('tasks.forceDelete');
//    Route::post('/tasks/{task}/status', 'updateStatus')->name('tasks.updateStatus');

});

Route::controller(ComicCommentController::class)->middleware('auth')->group(function () {
    Route::post('/comics/{comic}/comments', 'store')->name('comments.store');
});

