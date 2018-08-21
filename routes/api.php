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
    Route::name('api.tickets.list')->get('tickets', 'Api\TicketsController@list');
    Route::name('api.tickets.store')->post('tickets/create', 'Api\TicketsController@store');

    Route::name('api.clients.list')->get('clients', 'Api\ClientsController@list');
    Route::name('api.clients.show')->get('clients/{cc}', 'Api\ClientsController@show');
    Route::name('api.sim.gen.client')->get('clients/{cc}/generate', 'Api\ClientsController@generateIdentity');

    Route::name('api.cashiers.next')->get('cashiers/{id}/next', 'Api\CashiersController@next');

    Route::name('api.ping')->get('ping', function() { return response()->json(1, 200); });
});
