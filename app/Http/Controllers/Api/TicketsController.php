<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;
use App\Client;
use App\Agency;
use App\Http\Resources\ClientResourse;
use App\Library\QueueManager;
use App\Http\Requests\NewTicket as TicketRequest;

class TicketsController extends Controller
{

    //
    public function list()
    {
        return Ticket::all();
    }

    public function store(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);
        $client = $this->queue->clientFromRequest($request);
        $ticket = $this->queue->newTicket($client, $agency);

        return $ticket;
    }
}
