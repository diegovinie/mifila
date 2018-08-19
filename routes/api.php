<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('tickets', 'Api\TicketsController@list');
    Route::post('tickets/create', 'Api\TicketsController@store');

    Route::get('clients', 'Api\ClientsController@list');
    Route::get('clients/{cc}', 'Api\ClientsController@show');
    Route::get('clients/{cc}/generate', 'Api\ClientsController@generateIdentity');
});
