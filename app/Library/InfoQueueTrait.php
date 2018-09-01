<?php

namespace App\Library;

use App\Config;
use App\Ticket;
use App\Cashier;
use App\Agency;
use App\TicketService as Service;

trait InfoQueueTrait
{
    public function infoAll()
    {
        $acc = $this->infoAcc();
        $clientsRate = $this->infoClientsRate();
        $queue = $this->infoQueue();
        $cashiers = $this->infoCashiers();
        $finished = $this->infoFinished();
        $avg = $this->infoAvg();
        $agencies = $this->infoAgencies();
        $simActive = $this->simActive();

        return compact(
            'queue',
            'cashiers',
            'finished',
            'avg',
            'agencies',
            'acc',
            'clientsRate',
            'simActive'
        );
    }

    public function simActive()
    {
        return env('APP_SIM', false);
    }

    public function infoAcc()
    {
        return Config::whereName('acc')->first()->current;
    }

    public function infoClientsRate()
    {
        return Config::whereName('clients_rate')->first()->current;
    }

    public function infoQueue()
    {
        return Ticket::isPending()->count();
    }

    public function infoCashiers()
    {
        return Cashier::isActive()->count();
    }

    public function infoFinished()
    {
        return Service::finishedToday()->count();
    }

    public function infoAvg()
    {
        try {
            return (int)Ticket::avgWait();

        } catch (\Exception $e) {
            return 0;
        }

    }

    public function infoAgencies()
    {
        $agencies = Agency::with('cashiers')->get();

        foreach ($agencies as $agency) {
            // code...
            $agency->info = $this->infoAgencyAll($agency);
        }

        return $agencies;
    }

    public function infoAgencyAll(Agency $agency)
    {
        $queue = $this->infoAgencyQueue($agency);
        $cashiers = $this->infoAgencyCashiers($agency);
        $finished = $this->infoAgencyFinished($agency);
        $avg = $this->infoAgencyAvg($agency);

        $lastCalled = $this->currentTicket($agency);
        $queuedClientsList = $this->queuedClientsList($agency);

        return compact(
            'queue',
            'cashiers',
            'finished',
            'avg',
            'lastCalled',
            'queuedClientsList'
        );
    }

    public function infoAgencyQueue(Agency $agency)
    {
        return $agency->tickets()->isPending()->count();
    }

    public function infoAgencyCashiers(Agency $agency)
    {
        return $agency->cashiers()->isActive()->count();
    }

    public function infoAgencyFinished(Agency $agency)
    {
        return $agency->services()->finishedToday()->count();
    }

    public function infoAgencyAvg(Agency $agency)
    {
        try {
            return (int)$agency->tickets()->avgWait();

        } catch (\Exception $e) {
            return 0;
        }
    }

    public function currentTicket(Agency $agency)
    {
        $service = $agency->services()->latest()->first();

        if (!$service) {
            return;
        }

        return $service->ticket->num;
    }

    public function queuedClientsList(Agency $agency)
    {
        return $agency->tickets()->with('client')->isPending()->get();
    }
}
