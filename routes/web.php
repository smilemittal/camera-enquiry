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
    return view('layout.home');
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