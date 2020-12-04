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
    return view('layouts.home');
});

Route::get('standards/create','StandardsController@create')->name('standards.create');
Route::post('standards/store','StandardsController@store')->name('standards.store');
Route::get('standards/index','StandardsController@index')->name('standards.index');
Route::get('standards/edit/{id}','StandardsController@edit')->name('standards.edit');
Route::patch('standards/update/{id}','StandardsController@update')->name('standards.update');
Route::delete('standards/destroy/{id}','StandardsController@destroy')->name('standards.destroy');
Route::post('standards/getstandard','StandardsController@getStandard')->name('get.standards');









