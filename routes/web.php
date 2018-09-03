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

Route::name('home')->get('/', function () {
    return view('home');
});

Route::name('admin')->get('admin', function () {
    return view('admin');
});

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('charts', function () {
    return view('charts');
});

// Route::get('tickets', 'TicketsController@list');
// Route::post('tickets/create', 'TicketsController@store');

// Route::resource('config', 'ConfigController');
