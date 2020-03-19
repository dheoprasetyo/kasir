<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    protected $fillable=['id','order_id','product_id','product_name','product_price','qty','subtotal'];

    // mengetahui jumlah product yang dipesan oleh customer
    public function item($order)
    {
        return $this->where('order_id', $order)->count();
    }
}
