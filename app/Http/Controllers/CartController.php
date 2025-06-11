<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class CartController extends Controller
{
    public function add(Comic $comic,request $request){
//        if(!Auth::check()){
//            return view('auth.login');
//        }else{
            $quantity = 1;
            if ($request->filled('quantity')){
                $quantity = $request->quantity;
            }

            $cart = session('cart',[]);

            if (isset($cart[$comic->id])){
                if ($cart[$comic->id]['quantity'] != $comic->stock){
                    if ($cart[$comic->id]['quantity']+ $quantity <= $comic->stock){
                        $cart[$comic->id]['quantity'] = $cart[$comic->id]['quantity']+ $quantity;
                    } else{
                        $cart[$comic->id]['quantity'] = $comic->stock;
                    }
                }
            }else {
                $cart[$comic->id] = [
                    'id' => $comic->id,
                    'title' => $comic->title,
                    'quantity' => $quantity,
                    'thumbnail_image' => $comic->thumbnail_image,
                    'price' => $comic->price,
                    'stock' => $comic->stock
                ];
            }


            $request->session()->put('cart', $cart);

            return redirect()->back()->with('success',__('notifications.added_to_cart'));
//        }
    }

    public function index(){
        return view('cart.index');
    }
    public function update(Request $request){
        info($request->all());
        $cart = session('cart',[]);

        if ($request->type=='update'){
            $cart[$request->id]['quantity'] = $request->quantity;
        } else{
            unset($cart[$request->id]);
        }
        session()->put('cart', $cart);
        $view = view('partials.cartProducts')->render();

        return response()->json(['success'=>$view]);
    }

    public function unsetComic(Request $request){
        $cart = session('cart',[]);

        unset($cart[$request->id]);

        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function confirmOrder(Request $request){
        if(!Auth::check()){
            return view('auth.login');
        }

        $cart = session('cart',[]);

        if (empty($cart)){
            return redirect()->route('cart.index');
        }
        return view('cart.confirmOrder');
    }

    public function placeOrder(Request $request){
        $cart = session('cart', []); // Obtiene el carrito o un array vacío

        if (empty($cart)) {
            return redirect('/')->with('success', __('notifications.empty_cart'));
        }
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'zipcode' => 'required|integer',
            'phone' => 'required|integer|digits:9',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => 0,
            'status' => 'pending confirmation',
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'phone' => $request->phone,
        ]);

        $total = 0;
        foreach ($cart = session('cart') as $id => $item){
            $order->items()->create([
                'comic_id' => $id,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ]);

            $total += $item['quantity'] * $item['price'];
        }
        $order->total_price = $total;
        $order->save();


        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $successURL = route('cart.orderSuccess').'?session_id={CHECKOUT_SESSION_ID}&order_id='.$order->id;
        $response = $stripe->checkout->sessions->create([
            'success_url' => $successURL,
            'customer_email' => auth()->user()->email,
            'line_items' => [
                [
                    'price_data' => [
                        "product_data" => [
                            "name" => 'LuqueComics'
                        ],
                        'unit_amount' => $total * 100,
                        'currency' => 'EUR',
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);
        return redirect($response['url']);
    }

    public function orderSuccess(Request $request){

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $session = $stripe->checkout->sessions->retrieve($request->session_id);

        if($session['status'] == 'complete'){
            $order = Order::find($request->order_id);

            $order->status = 'in progress';
            $order->stripe_id = $session->id;
            $order->save();
            foreach ($order->items as $item){
                $comic = Comic::find($item->comic_id);
                if ($comic->stock - $item->quantity < 0){
                    $comic->stock = 0;
                } else{
                    $comic->stock -= $item->quantity;
                }
                $comic->save();
            }

            session()->forget('cart');
            return redirect()->route('session.orders');
        }

        $order = Order::find($request->order_id);
        $order->status = 'canceled';
        $order->save();

        dd('Failed');

    }

}
