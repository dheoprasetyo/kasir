<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('template.default');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('dashboard');
Route::group(['middleware' => 'role:kasir','auth'], function () {
    Route::get('search','HomeController@search')->name('search');
    Route::post('add-product','CartController@addProduct')->name('addProduct');
    Route::delete('cart/{cart}/delte','CartOrderController@destroy')->name('cart_order.destroy');
    Route::post('process','OrderController@process')->name('process');
    Route::get('detailOrder','OrderController@detailOrder')->name('detailorder');
    Route::get('order/{order}/receipt','OrderController@receipt')->name('receipt');
});
