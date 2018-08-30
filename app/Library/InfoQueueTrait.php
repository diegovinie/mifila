<?php

namespace App\Library;

use App\Config;
use App\Ticket;
use App\Cashier;
use App\Agency;
use App\TicketService as Service;

trait InfoQueueTrait
{
    public function infoAll(QueueManager $qm)
    {
        $acc = $this->infoAcc();
        $clientsRate = $this->infoClientsRate();
        $queue = $this->infoQueue();
        $cashiers = $this->infoCashiers();
        $finished = $this->infoFinished();
        $avg = $this->infoAvg();
        $agencies = $this->infoAgencies($qm);

        return compact(
            'queue',
            'cashiers',
            'finished',
            'avg',
            'agencies',
            'acc',
            'clientsRate'
        );
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

    public function infoAgencies(QueueManager $qm)
    {
        $agencies = Agency::all();

        foreach ($agencies as $agency) {
            // code...
            $agency->info = $this->infoAgencyAll($qm, $agency);
        }

        return $agencies;
    }

    public function infoAgencyAll(QueueManager $qm, Agency $agency)
    {
        // $agency = Agency::findOrFail($id);

        $queue = $this->infoAgencyQueue($agency);
        $cashiers = $this->infoAgencyCashiers($agency);
        $finished = $this->infoAgencyFinished($agency);
        $avg = $this->infoAgencyAvg($agency);

        $lastCalled = $qm->currentTicket($agency);

        return compact(
            'queue',
            'cashiers',
            'finished',
            'avg',
            'lastCalled'
        );
    }

    public function infoAgencyQueue(Agency $agency)
    {
        // $agency = Agency::findOrFail($id);

        return $agency->tickets()->isPending()->count();
    }

    public function infoAgencyCashiers(Agency $agency)
    {
        // $agency = Agency::findOrFail($id);

        return $agency->cashiers()->isActive()->count();
    }

    public function infoAgencyFinished(Agency $agency)
    {
        // $agency = Agency::findOrFail($id);

        return $agency->services()->finishedToday()->count();
    }

    public function infoAgencyAvg(Agency $agency)
    {
        // $agency = Agency::findOrFail($id);

        try {
            return (int)$agency->tickets()->avgWait();

        } catch (\Exception $e) {
            return 0;
        }
    }
}
