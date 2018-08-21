<?php

namespace App\Observers;
use App\Ticket;

class TicketObserver
{
   public function creating(Ticket $ticket)
   {
       try {
           $lastTicket = \DB::table('tickets')->find(\DB::table('tickets')->max('id'));
           $day = new \DateTime($lastTicket->created_at);

           if ((new \DateTime)->format('Ymd') == $day->format('Ymd')) {
               $group = preg_replace('/^([A-Z]).+/', '$1', $lastTicket->num);
               $numeral = (integer)preg_replace('/[A-Z]+(\d+)$/', '$1', $lastTicket->num);
               ++$numeral;
               $ticket->num = $group . (string)$numeral;
           } else {
               $ticket->num = 'T1';
           }
       } catch (\Exception $e) {
           $ticket->num = 'T1';
       }
   }
}
