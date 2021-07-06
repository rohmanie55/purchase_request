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
Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('report', 'HomeController@report')->name('report');
    Route::post('report/{report}/print', 'HomeController@print')->name('print');
    Route::post('order/{order}/approve', 'OrderController@approve')->name('order.approve');
    Route::resource('user', 'UserController');
    Route::resource('request', 'RequestController');
    Route::resource('order', 'OrderController');
    Route::resource('pembelian', 'BeliController');
    Route::resource('barang', 'BarangController');
    Route::resource('supplier', 'SupplierController');
});
