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

Route::get('standards/create','StandardsController@create')->name('standards.create');
Route::post('standards/store','StandardsController@store')->name('standards.store');
Route::get('standards/index','StandardsController@index')->name('standards.index');
Route::get('standards/edit/{id}','StandardsController@edit')->name('standards.edit');
Route::patch('standards/update/{id}','StandardsController@update')->name('standards.update');
Route::delete('standards/destroy/{id}','StandardsController@destroy')->name('standards.destroy');
Route::post('standards/getstandard','StandardsController@getStandard')->name('get.standards');

Route::resource('attribute', 'AttributeController');

