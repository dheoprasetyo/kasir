<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel cart ini kita umpamakan sebagai keranjang belanja yang menjadi tempat untuk menyimpan sementara data menu yang dipilih oleh pembeli/customer. Tabel cart ini akan berelasi ke tabel products yang sebelumnya sudah kita buat.
class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->integer('product_price');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
