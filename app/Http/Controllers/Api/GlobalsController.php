<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Ticket;
use App\Cashier;
use App\TicketService as Service;

class GlobalsController extends Controller
{
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
}
