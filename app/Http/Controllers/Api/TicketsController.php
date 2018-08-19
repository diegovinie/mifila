<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Client;
use App\Agency;

class TicketsController extends Controller
{
    //
    public function list()
    {
        return Ticket::all();
    }

    public function store(Request $request)
    {
        $cc = $request->get('cc');
        if (!$client = Client::find($cc)) {
            $client = Client::create([
                'cc' => $cc,
                'name' => $request->get('name'),
                'gender' => $request->get('gender'),
                'phone' => $request->get('phone'),
                'priority' => $request->get('priority') || false,
            ]);
        }

        $ticket = new Ticket;

        $agency = Agency::find($request->get('agency_id'));

        $ticket->client()->associate($client);
        $ticket->agency()->associate($agency);
        $ticket->save();

        return $ticket;
    }
}
