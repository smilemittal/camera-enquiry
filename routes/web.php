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
    return view('welcome');
});
// Route::get('system_types/create', 'SystemTypesController@create')->name('system_types.create');
// Route::post('system_types/store', 'SystemTypesController@store')->name('system_types.store');
// Route::get('system_types/index',  'SystemTypesController@index')->name('system_types.index');
// Route::get('system_types/edit/{id}','SystemTypesController@edit')->name('system_types.edit');
// Route::patch('system_types/update/{id}','SystemTypesController@update')->name('system_types.update');
// Route::delete('system_types/destroy/{id}','SystemTypesController@destroy')->name('system_types.destroy');
Route::resource('system_types', 'SystemTypesController');
Route::post('system_types/fetchtypes','SystemTypesController@getSystemTypes')->name('get.system_types');

Route::resource('attribute-values', 'AttributeValuesController');
Route::post('attribute-values/fetchtypes','AttributeValuesController@getAttributeValues')->name('get.attribute_values');


Route::get('products/create','ProductController@create')->name('product.create');
Route::post('products/store','ProductController@store')->name('product.store');
Route::get('products/index','ProductController@index')->name('product.index');
Route::delete('products/destroy/{id}','ProductController@destroy')->name('product.destroy');
Route::get('products/edit/{id}','ProductController@edit')->name('product.edit');
Route::patch('products/update/{id}','ProductController@update')->name('product.update');
Route::post('products/getproduct','ProductController@getproduct')->name('get.product');

Route::get('standards/create','StandardsController@create')->name('standards.create');
Route::post('standards/store','StandardsController@store')->name('standards.store');
Route::get('standards/index','StandardsController@index')->name('standards.index');
Route::get('standards/edit/{id}','StandardsController@edit')->name('standards.edit');
Route::patch('standards/update/{id}','StandardsController@update')->name('standards.update');
Route::delete('standards/destroy/{id}','StandardsController@destroy')->name('standards.destroy');
Route::post('standards/getstandard','StandardsController@getStandard')->name('get.standards');

Route::resource('attribute', 'AttributeController');
Route::post('attribute/get-attribute', 'AttributeController@getAttribute')->name('get.attribute');


 Route::resource('product-attribute', 'ProductAttributesController');