<?php

namespace App\Observers;
use App\TicketService;

class TicketServiceObserver
{
   public function creating(TicketService $service)
   {
       $now = new \DateTime;

       $duration = function ($rate) {
           $min = $rate * 80;
           $max = $rate * 120;
           $duration = mt_rand($min, $max) / 100;

           return (int)$duration;
       };

       $seconds = $duration($service->cashier->rate);

       $service->duration = $seconds;
       $service->due = $now->add(new \DateInterval("PT{$seconds}S"));
   }
}
