<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addItem($productId)
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        if (!$cart) {
            $cart = new \App\Models\Cart();
            $cart->user_id = Auth::user()->id;
            $cart->save();
        }

        $cartItem = new \App\Models\CartItem();
        $cartItem->product_id = $productId;
        $cartItem->cart_id = $cart->id;
        $cartItem->save();

        return redirect('/cart');
    }

    public function showCart()
    {
        $cart = Cart::where('user_id', Auth::user()->id)->first();

        if (!$cart) {
            $cart = new \App\Models\Cart();
            $cart->user_id = Auth::user()->id;
            $cart->save();
        }

        $items = $cart->cartItems;
        $total = 0;
        foreach ($items as $item) {
            $total += $item->product->price;
        }

        return view('cart.view', ['items' => $items, 'total' => $total]);
    }

    public function removeItem($id)
    {
        CartItem::destroy($id);
        return redirect('/cart');
    }
}
