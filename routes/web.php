<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

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
//     return view('welcome');
// });


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('languages', 'LanguageController');

    Route::get('system-types/import','SystemTypesController@importSystemTypes')->name('system-types.import');
    Route::post('system-types/post-import','SystemTypesController@postImport')->name('system-types.post-import');
    Route::get('system-types/export','SystemTypesController@export')->name('system-types.export');
    Route::post('system-types/fetchtypes','SystemTypesController@getSystemTypes')->name('get.system_types');
    Route::post('system-types/multiple-delete','SystemTypesController@multipleDelete')->name('system-types.multipledelete');
    Route::resource('system-types', 'SystemTypesController');


    Route::get('types/import','TypesController@importTypes')->name('types.import');
    Route::get('types/export','TypesController@export')->name('types.export');
    Route::resource('types', 'TypesController');
    Route::post('types/fetchtypes','TypesController@getTypes')->name('get.types');
    Route::post('types/post-import','TypesController@postImport')->name('types.post-import');
    Route::post('types/multiple-delete','TypesController@multipleDelete')->name('types.multipledelete');



    Route::get('standards/import', 'StandardsController@importStandards')->name('standards.import');
    Route::post('standards/post-import', 'StandardsController@postImport')->name('standards.post-import');
    Route::get('standards/export','StandardsController@export')->name('standards.export');
    Route::post('standards/getstandard','StandardsController@getStandard')->name('get.standards');
    Route::post('standards/multiple-delete','StandardsController@multipleDelete')->name('standards.multipledelete');
    Route::resource('standards', 'StandardsController');


    Route::post('attribute/get-attribute', 'AttributeController@getAttribute')->name('get.attribute');
    Route::get('attribute/export','AttributeController@export')->name('attribute.export');
    Route::get('attribute/import', 'AttributeController@importAttributeValues')->name('attribute.import');
    Route::post('attribute/post-import', 'AttributeController@postImport')->name('attribute.post-import');
    Route::post('attribute/multiple-delete','AttributeController@multipleDelete')->name('attributes.multipledelete');
    Route::resource('attribute', 'AttributeController');

    Route::post('get-attributes', 'AttributeValuesController@getAttributes')->name('get-attributes');
    Route::resource('attribute-values', 'AttributeValuesController');
    Route::post('attribute-values/multiple-delete','AttributeValuesController@multipleDelete')->name('attribute_value.multipledelete');
    Route::post('attribute-values/fetchtypes','AttributeValuesController@getAttributeValues')->name('get.attribute_values');


    Route::post('products/getproduct','ProductController@getproduct')->name('get.product');
    Route::post('products/multiple-delete','ProductController@multipleDelete')->name('products.multipledelete');
    Route::resource('products', 'ProductController');

    Route::get('product-attributes/import', 'ProductAttributesController@importProductAttribute')->name('product-attributes.import');
    Route::post('product-attributes/post-import', 'ProductAttributesController@postImport')->name('product-attributes.post-import');
    Route::get('product-attributes/export' , 'ProductAttributesController@export')->name('product-attributes.export');
    Route::post('product-attributes/fetchtypes','ProductAttributesController@getProductAttribute')->name('get.ProductAttributes');
    Route::resource('product-attributes','ProductAttributesController');


    Route::get('enquiries', 'EnquiryController@index')->name('enquiries.index');
    Route::get('enquiries/{id}/show', 'EnquiryController@show')->name('enquiries.show');
    Route::post('enquiries/multiple-delete','EnquiryController@multipleDelete')->name('enquiries.multipledelete');

    Route::delete('enquiries/{id}/destroy', 'EnquiryController@destroy')->name('enquiries.destroy');



    // Route::get('/logout' , function (){
    //     \Illuminate\Support\Facades\Auth::logout();
    //     return redirect()->route('login');
    // })->name('logout');
});

//Front routes
Route::post('get-product-attributes', 'ProductController@getProductAttributes')->name('get-product-attributes');
Route::post('get-standard-attributes', 'ProductController@getStandard')->name('get-standard-attributes');

Route::post('get-enquiry-attributes', 'FrontController@getEnquiryProductAttributes')->name('get-enquiry-attributes');
Route::post('update-attributes', 'FrontController@updateAttributes')->name('update-attributes');
Route::get('/', 'FrontController@home')->name('home');
Route::post('get-next-product', 'FrontController@getNextProduct')->name('get-next-product');
Route::post('get-standard', 'FrontController@getStandard')->name('get-standard');

Route::post('save-enquiry', 'FrontController@saveEnquiry')->name('save-enquiry');
//Route::post('get-summary', 'FrontController@getSummary')->name('get-summary');




Route::post('get-enquiries', 'EnquiryController@getEnquiries')->name('get.enquiries');
Route::post('print-enquiries', 'FrontController@printEnquiry')->name('print.enquiries');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
