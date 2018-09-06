<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Ticket;
use App\Cashier;
use App\Agency;
use App\TicketService as Service;
use App\Config;
use App\Library\InfoQueueTrait;
use App\Library\QueueManager;

class GlobalsController extends Controller
{
    use InfoQueueTrait;

    public function all()
    {
        return $this->infoAll(true);
    }

    public function queue()
    {
        return $this->infoQueue();
    }

    public function cashiers()
    {
        return $this->infoCashiers();
    }

    public function finished()
    {
        return $this->infoFinished();
    }

    public function avg()
    {
        return $this->infoAvg();
    }

    public function agencies(QueueManager $qm)
    {
        return $this->infoAgencies($qm);
    }

    public function deletePending()
    {
        $pending = Ticket::isPending()->get();

        foreach ($pending as $ticket) {
            // code...
            $ticket->delete();
        }

        return response()->json(null, 200);
    }

    public function deleteTickets()
    {
        $tickets = Ticket::all();

        foreach ($tickets as $ticket) {
            // code...
            $ticket->services()->delete();
            $ticket->delete();
        }
    }

    public function listServices(Request $request)
    {
        if ($day = $request->query('day')) {
            $day = (new \DateTime($day))->format('Y-m-d');
            return Service::whereDate('created_at', '=', $day)->get();
        }
        return Service::all();
    }
}
