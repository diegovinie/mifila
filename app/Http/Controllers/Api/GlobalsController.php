<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Ticket;
use App\Cashier;
use App\TicketService as Service;

class GlobalsController extends Controller
{
    public function all()
    {
        $queue = $this->queue();
        $cashiers = $this->cashiers();
        $finished = $this->finished();
        $avg = $this->avg();

        return response()->json(compact('queue', 'cashiers', 'finished', 'avg'));
    }

    public function queue()
    {
        return Ticket::isPending()->count();
    }

    public function cashiers()
    {
        return Cashier::isActive()->count();
    }

    public function finished()
    {
        return Service::finishedToday()->count();
    }

    public function avg()
    {
        return (int)Ticket::avgWait();
    }
}
