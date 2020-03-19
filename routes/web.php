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

Route::get('/', 'HomeController@index');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('dashboard');
Route::group(['middleware' => 'role:kasir','auth'], function () {
    Route::get('search','HomeController@search')->name('search');
    Route::post('add-product','CartController@addProduct')->name('addProduct');
    Route::delete('cart/{cart}/delete','CartController@destroy')->name('cart_order.destroy');
    Route::post('process','OrderController@process')->name('process');
    Route::get('detailOrder','OrderController@detailOrder')->name('detailorder');
    Route::get('order/{order}/receipt','OrderController@receipt')->name('receipt');
});
Route::group(['middleware'=>'role:owner','auth'], function(){
    Route::resource('category','CategoryController');
    Route::get('product/category','ProductController@category')->name('product.category');
    Route::get('product/{category}/index','ProductController@index')->name('product.index');
    Route::get('product/{category}/index/create','ProductController@create')->name('product.create');
    Route::post('product/{category}/index/create','ProductController@store')->name('product.store');
    Route::get('product/{category}/index/product/{product}/edit','ProductController@edit')->name('product.edit');
    Route::put('product/{category}/index/product/{product}/edit','ProductController@update')->name('product.update');
    Route::delete('product/{category}/index/product/{product}/delete','ProductController@destroy')->name('product.destroy');
    Route::get('penjualan', 'OrderController@index')->name('order.index');
    Route::get('penjualan/{order}/detail','OrderController@show')->name('order.show');
    Route::get('report','ReportController@index')->name('report.index');
    Route::get('report/changeperiode','ReportController@changePeriode')->name('report.changePeriode');
    Route::resource('profile','ProfileController');
    
});