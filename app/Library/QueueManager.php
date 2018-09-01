<?php

namespace App\Library;

use Illuminate\Http\Request;
use App\Cashier;
use App\Client;
use App\Agency;
use App\Ticket;
use App\Config;
use App\TicketService as Service;
use App\Events\UpdateAgency;
use App\Events\UpdateGlobals;

class QueueManager
{
    use InfoQueueTrait;

    public function cashierCalls(Cashier $cashier)
    {
        $ticket = $cashier->nextTicket();

        if (!$ticket) {
            return;
        }

        $service = new Service;
        $service->cashier()->associate($cashier);
        $service->ticket()->associate($ticket);
        $service->agency()->associate($cashier->agency);
        $service->save();

        $infoAgency = $this->infoAgency($cashier->agency);
        $infoGlobal = $this->infoAll();

        event(new UpdateAgency($infoAgency));
        event(new UpdateGlobals($infoGlobal));

        return $service->fresh()->load('ticket');
    }

    public function newTicket(Client $client, Agency $agency)
    {
        $ticket = new Ticket;

        $ticket->client()->associate($client);
        $ticket->agency()->associate($agency);
        $ticket->save();

        $infoAgency = $this->infoAgency($agency);
        $infoGlobal = $this->infoAll();

        event(new UpdateAgency($infoAgency));
        event(new UpdateGlobals($infoGlobal));

        return $ticket;
    }

    public function getClient(array $metadata)
    {
        if (!$client = Client::find($metadata['cc'])) {

            $client = Client::create($metadata);
        }

        return $client;
    }

    public function clientFromCC($cc)
    {
        return Client::find($cc);
    }

    public function clientFromRequest(Request $request)
    {
        $metadata = [
            'cc' => $request->get('cc'),
            'name' => $request->get('name'),
            'gender' => $request->get('gender'),
            'phone' => $request->get('phone'),
            'priority' => $request->get('priority') || false,
        ];

        return $this->getClient($metadata);
    }

    public function checkClientQueue(Client $client)
    {
        $ticket = $client->tickets()->isPending()->first();
        if (!$ticket) {
            return;
        }

        return $ticket;
    }
}
