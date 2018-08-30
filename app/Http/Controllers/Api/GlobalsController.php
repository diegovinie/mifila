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
        return $this->infoAll();
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

    public function agencies($qm)
    {
        return $this->infoAgencies($qm);
    }
}
