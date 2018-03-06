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

Route::get('/', 'UploadController@index')->name('home');
Route::get('/display', 'DisplayController@index')->name('display');
Route::get('/get-table', 'DisplayController@getTable')->name('get-table');

Route::post('/truncate', 'UploadController@truncateDB')->name('truncate');
Route::post('load', 'UploadController@load')->name('load');