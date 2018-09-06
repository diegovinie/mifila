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
    Route::name('tickets.store')->post('agencies/{agency}/tickets/create', 'Api\TicketsController@store');
    Route::name('tickets.delete')->delete('tickets/{ticket}', 'Api\TicketsController@delete');

    Route::name('clients.list')->get('clients', 'Api\ClientsController@list');
    Route::name('clients.show')->get('clients/{cc}', 'Api\ClientsController@show');
    Route::name('clients.checkTicket')->get('clients/{cc}/check', 'Api\ClientsController@check');
    Route::name('sim.gen.client')->get('clients/{cc}/generate', 'Api\ClientsController@generateIdentity');
    Route::name('clients.tickets')->get('clients/{client}/tickets', 'Api\ClientsController@tickets');

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
    Route::name('globals.agencies')->get('globals/agencies', 'Api\GlobalsController@agencies');
    Route::name('globals.delete.pending')->delete('globals/pending', 'Api\GlobalsController@deletePending');
    Route::name('globals.delete.tickets')->delete('globals/tickets', 'Api\GlobalsController@deleteTickets');

    Route::name('agencies.info')->get('agencies/{id}/info', 'Api\AgenciesController@all');
    Route::name('agencies.generateCashier')
        ->get('agencies/{agency}/cashiers/generate', 'Api\AgenciesController@generateCashier');
    Route::name('agencies.delete.pending')
        ->delete('agencies/{agency}/pending', 'Api\AgenciesController@deletePending');
    Route::name('agencies.delete.tickets')
        ->delete('agencies/{agency}/tickets', 'Api\AgenciesController@deleteTickets');

    Route::name('ping')->get('ping', function() { return response()->json(1, 200); });

    Route::apiResource('configs', 'Api\ConfigController')
        ->only('index', 'show', 'update', 'next');
    Route::name('configs.items')->get('configs/{config}/items', 'Api\ConfigController@items');

    Route::name('globals.services')
        ->get('globals/services', 'Api\GlobalsController@listServices');

});
