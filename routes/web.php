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



Route::get('system-types/import','SystemTypesController@importSystemTypes')->name('system-types.import');
Route::post('system-types/post-import','SystemTypesController@postImport')->name('system-types.post-import');
Route::get('system-types/export','SystemTypesController@export')->name('system-types.export');
Route::post('system-types/fetchtypes','SystemTypesController@getSystemTypes')->name('get.system_types');
Route::resource('system-types', 'SystemTypesController');

Route::get('standards/import', 'StandardsController@importStandards')->name('standards.import');
Route::post('standards/post-import', 'StandardsController@postImport')->name('standards.post-import');
Route::get('standards/export','StandardsController@export')->name('standards.export');
Route::post('standards/getstandard','StandardsController@getStandard')->name('get.standards');
Route::resource('standards', 'StandardsController');

Route::resource('attribute', 'AttributeController');
Route::post('attribute/get-attribute', 'AttributeController@getAttribute')->name('get.attribute');

Route::get('attribute-values/import', 'AttributeValuesController@importAttributeValues')->name('attribute-values.import');
Route::post('attribute-values/post-import', 'AttributeValuesController@postImport')->name('attribute-values.post-import');
Route::get('attribute-values/export', 'AttributeValuesController@export')->name('attribute-values.export');
Route::resource('attribute-values', 'AttributeValuesController');
Route::post('attribute-values/fetchtypes','AttributeValuesController@getAttributeValues')->name('get.attribute_values');



Route::post('products/getproduct','ProductController@getproduct')->name('get.product');
Route::resource('products', 'ProductController');

Route::get('product-attributes/import', 'ProductAttributesController@importProductAttribute')->name('product-attributes.import');
Route::post('product-attributes/post-import', 'ProductAttributesController@postImport')->name('product-attributes.post-import');
Route::get('product-attributes/export' , 'ProductAttributesController@export')->name('product-attributes.export');
Route::post('product-attributes/fetchtypes','ProductAttributesController@getProductAttribute')->name('get.ProductAttributes');
Route::resource('product-attributes','ProductAttributesController');

//Front routes
Route::post('get-product-attributes', 'ProductController@getProductAttributes')->name('get-product-attributes');
Route::get('home', 'FrontController@home')->name('home');
Route::post('get-enquiry-attributes', 'FrontController@getEnquiryProductAttributes')->name('get-enquiry-attributes');
Route::post('update-attributes', 'FrontController@updateAttributes')->name('update-attributes');