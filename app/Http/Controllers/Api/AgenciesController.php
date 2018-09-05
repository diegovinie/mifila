<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agency;
use App\Ticket;
use App\Library\QueueManager;
use App\Events\UpdateAgency;

class AgenciesController extends Controller
{
    //
    public function all(QueueManager $qm, $id)
    {
        $agency = Agency::findOrFail($id);
        $name = $agency->name;
        $queue = $this->queue($id);
        $cashiers = $this->cashiers($id);
        $finished = $this->finished($id);
        $avg = $this->avg($id);

        $lastCalled = $qm->currentTicket($agency);

        return response()->json(compact(
            'queue',
            'cashiers',
            'finished',
            'avg',
            'name',
            'lastCalled'
        ));
    }

    public function queue($id)
    {
        $agency = Agency::findOrFail($id);

        return $agency->tickets()->isPending()->count();
    }

    public function cashiers($id)
    {
        $agency = Agency::findOrFail($id);

        return $agency->cashiers()->isActive()->count();
    }

    public function finished($id)
    {
        $agency = Agency::findOrFail($id);

        return $agency->services()->finishedToday()->count();
    }

    public function avg($id)
    {
        $agency = Agency::findOrFail($id);

        try {
            return (int)$agency->tickets()->avgWait();

        } catch (\Exception $e) {
            return 0;
        }
    }

    public function generateCashier(QueueManager $qm, Agency $agency)
    {
        $cashier = factory(\App\Cashier::class)->make();
        $agency->cashiers()->save($cashier);

        $infoAgency = $qm->infoAgency($agency);
        event(new UpdateAgency($infoAgency));

        return $cashier;
    }

    public function deletePending(QueueManager $qm, Agency $agency)
    {
        $pending = $agency->tickets()->isPending()->get();

        foreach ($pending as $ticket) {
            // code...
            $ticket->delete();
        }

        $infoAgency = $qm->infoAgency($agency);
        event(new UpdateAgency($infoAgency));

        return response()->json(null, 200);
    }

    public function deleteTickets(QueueManager $qm, Agency $agency)
    {
        $tickets = $agency->tickets;

        foreach ($tickets as $ticket) {
            // code...
            $ticket->services()->delete();
            $ticket->delete();
        }

        $infoAgency = $qm->infoAgency($agency);
        event(new UpdateAgency($infoAgency));

        return response()->json(null, 200);
    }
}
