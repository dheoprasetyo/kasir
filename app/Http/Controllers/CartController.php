<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        Cart::create([
            'product_id'=>$request->id,
            'product_name'=>$request->menu,
            'product_price'=>$request->price,
            'qty'=>$request->qty,
            'subtotal'=>$request->price * $request->qty
        ]);
        return redirect()->back();
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->back();
    }
}
