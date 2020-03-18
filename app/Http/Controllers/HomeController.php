<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Cart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cart_order = Cart::all();
        if(Auth::user()->hasRole('kasir')){
            return view('dashboard',compact('cart_order'));
        }
    }

    // Function ini kita gunakan untuk pencarian data product, apabila data ditemukan maka akan dikirimkan dalam bentuk json.
    public function search(Request $request)
    {
        $search = $request->term;
        $data = Product::where('name','LIKE','%'.$search.'%')
        ->take(10)
        ->get();
        $result=array();
        foreach ($data as $key => $value) {
            $result[]=['price'=>$value->price,'id'=>$value->id,'value'=>$value->name];
        }
        return response()->json($result);
    }
}
