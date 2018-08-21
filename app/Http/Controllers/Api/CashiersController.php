<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cashier;
use App\TicketService as Service;

class CashiersController extends Controller
{
    //
    public function next($id)
    {
        $cashier = Cashier::findOrFail($id);

        $ticket = $cashier->nextTicket();

        if (!$ticket) {
            return response()->json(null, 404);
        }

        $service = new Service;
        $service->cashier()->associate($cashier);
        $service->ticket()->associate($ticket);
        $service->save();

        return $service->fresh()->load('ticket');
    }
}
