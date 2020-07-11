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

Route::get('/', 'BookController@index')->name('index');
Route::post('add', 'BookController@store')->name('add_book');
Route::get('add', 'BookController@create')->name('add_new_view');
Route::delete('delete/{book}', 'BookController@destroy')->name('delete_Book');
