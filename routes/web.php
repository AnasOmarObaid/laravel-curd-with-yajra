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

Route::get('/', function () {
    return view('clients/index');
});

Route::resource('client', 'ClientController')->except(['create', 'show', 'update', 'destroy']);
Route::post('client/update/{id}', 'ClientController@update');
Route::delete('client/destroy/{id}', 'ClientController@destroy');


/* 

    *this route to get api and make table

*/

Route::get('api-post', function () {
    return view('Api.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
