<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert, Auth;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Orderdetail;
use App\Models\Profile;

class OrderController extends Controller
{
    // fungsi ini digunakan untuk memasukkan data ke dalam tabel orders dan orderdetails. Semua data yang ada di tabel cart akan dipindahkan ke tabel orderdetails, jadi tabel cart menjadi kosong dan bisa di isi untuk transaksi baru.
    public function process(Request $request)
    {
        $this->validate($request,[
            'customer' => 'required',
        ],
        [
            'customer.required'=>'Nama customer belum diisi'
        ]);

        if ($request->pay < $request->total) {;
            Alert::warning('Jumlah Pembayaran kurang');
            return redirect()->back();
        }

        $latest = Order::orderBy('id','DESC')->first();
        if(!$latest){
            $invoice = '0001';
        } else {
            $invoice = sprintf('%04d', $latest->invoice+1);
        }

        $cart_order = Cart::all();
        $order = Order::create([
            'invoice'=>$invoice,
            'customer_name'=>$request->customer,
            'total'=>$request->total,
            'pay'=>$request->pay,
            'user_id'=>Auth::user()->id,
            'note'=>$request->note
        ]);

        foreach ($cart_order as $item) {
            Orderdetail::create([
                'order_id'=>$order->id,
                'product_id'=>$item->product_id,
                'product_name'=>$item->product_name,
                'product_price'=>$item->product_price,
                'qty'=>$item->qty,
                'subtotal'=>$item->subtotal
            ]);
        }

        Cart::query()->truncate();
        return redirect()->route('detailorder');

    }

    // Function ini kita gunakan untuk menampilkan detail order.
    public function detailorder()
    {
        $lastOrder = Order::latest()->first();
        return view('detail',compact('lastOrder'));
    }

    // Fungsi ini akan digunakan untuk mencetak nota
    public function receipt(Order $order)
    {
        $profile = Profile::first();
        return view('receipt', compact('order','profile'));
    }
}
