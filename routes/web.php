<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('dashboard');
})->name('home');
Route::get('products/create','ProductController@create')->name('product.create');
Route::post('products/store','ProductController@store')->name('product.store');
Route::get('products/index','ProductController@index')->name('product.index');
Route::delete('products/destroy/{id}','ProductController@destroy')->name('product.destroy');
Route::get('products/edit/{id}','ProductController@edit')->name('product.edit');
Route::post('products/update/{id}','ProductController@update')->name('product.update');
Route::post('products/getproduct','ProductController@getproduct')->name('get.product');

Route::resource('attribute', 'AttributeController');

