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
use App\Events\UpdateAgency;

class TicketsController extends Controller
{

    //
    public function list()
    {
        return Ticket::all();
    }

    public function store(TicketRequest $request, Agency $agency)
    {
        $notifiable = $request->notifiable;
        $client = $this->queue->clientFromRequest($request);
        $ticket = $this->queue->newTicket($client, $agency, $notifiable);

        return $ticket;
    }

    public function delete(Ticket $ticket)
    {
        $agency = $ticket->agency;
        $res = $ticket->delete();

        if ($res) {
            $infoAgency = $this->queue->infoAgency($agency);
            event(new UpdateAgency($infoAgency));

            return response()->json(null, 200);
        }

        return response()->json(null, 422);
    }
}
