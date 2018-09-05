<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\Library\Simulator;
use App\Http\Resources\NewTicketResource as TicketResource;

class ClientsController extends Controller
{
    //
    public function show($cc)
    {
        $client = $this->queue->clientFromCC($cc);

        if (!$client) {
            return response()->json(null, 204);
        }
        $client->priority = (int)$client->priority;
        return $client;
    }

    public function list()
    {
        return Client::all();
    }

    public function generateIdentity($cc)
    {
        return Simulator::generateIdentity($cc);
    }

    public function check($clientid)
    {
        $client = Client::findOrFail($clientid);
        $ticket = $this->queue->checkClientQueue($client);

        if (!$ticket) {
            return response()->json(null, 204);
        }

        return response($ticket);
    }

    public function tickets(Client $client)
    {
        return $client->tickets()->with('agency')->isPending()->get();
    }
}
