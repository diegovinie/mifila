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

    public static function check(\App\Agency $agency)
    {

        $cashiers = $agency->cashiers()->get();

        foreach ($cashiers as $cashier) {
            // code...
            if ($cashier->idle) {
                $res = $this->next($cashier->id);
                var_dump($res);
            } else {
                var_dump($cashier);
            }
        }
    }
}
