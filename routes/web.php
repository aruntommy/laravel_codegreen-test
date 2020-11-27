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

Auth::routes();


Route::get('/user', 'UserController@index')->middleware('auth');
Route::post('/user', 'UserController@store');
Route::patch('/user/{id}', 'UserController@update')->middleware('auth');
Route::get('/mail/create', 'MailController@create');
Route::patch('/mail', 'MailController@update');
