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

Route::group([
        'prefix' => 'v1',
        'as' => 'api.',
        'middleware' => 'throttle:1000,1'], function () {

    Route::name('tickets.list')->get('tickets', 'Api\TicketsController@list');
    Route::name('tickets.store')->post('agencies/{id}/tickets/create', 'Api\TicketsController@store');

    Route::name('clients.list')->get('clients', 'Api\ClientsController@list');
    Route::name('clients.show')->get('clients/{cc}', 'Api\ClientsController@show');
    Route::name('clients.checkTicket')->get('clients/{cc}/check', 'Api\ClientsController@check');
    Route::name('sim.gen.client')->get('clients/{cc}/generate', 'Api\ClientsController@generateIdentity');

    Route::apiResource('cashiers', 'Api\CashiersController')
        ->only('index', 'show', 'update');
    Route::name('cashiers.next')->get('cashiers/{cashier}/next', 'Api\CashiersController@next');

    Route::name('globals.all')->get('globals', 'Api\GlobalsController@all');
    Route::name('globals.queue')
        ->get('globals/queue', 'Api\GlobalsController@queue');
    Route::name('globals.finished')
        ->get('globals/finished', 'Api\GlobalsController@finished');
    Route::name('globals.activeCashier')
        ->get('globals/cashiers/active', 'Api\GlobalsController@cashiers');
    Route::name('globals.avg')->get('globals/avg', 'Api\GlobalsController@avg');

    Route::name('agencies.info')->get('agencies/{id}/info', 'Api\AgenciesController@all');

    Route::name('ping')->get('ping', function() { return response()->json(1, 200); });

    Route::apiResource('configs', 'Api\ConfigController')
        ->only('index', 'show', 'update', 'next');
    Route::name('configs.items')->get('configs/{config}/items', 'Api\ConfigController@items');
    // Route::get('configs', 'Api\ConfigController@index');
    // Route::get('configs/{config}', 'Api\ConfigController@show');
    // Route::put('configs/{config}', 'Api\ConfigController@update');
});
