<?php

namespace App\Observers;
use App\Ticket;

class TicketObserver
{
   public function creating(Ticket $ticket)
   {
       // $condition = 'Ymd';
       $condition = 'H';
       $now = new \DateTime();

       try {
           $lastTicket = $ticket->agency->tickets()->latest()->first();
           $last = new \DateTime($lastTicket->created_at);

           if ($now->format($condition) == $last->format($condition)) {
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

   public function updating(Ticket $ticket)
   {
       if ($ticket->pending == false) {

           $now = (new \DateTime)->getTimestamp();
           $created = (new \DateTime($ticket->created_at))->getTimestamp();

           $ticket->waited = $now - $created;
       }
   }
}
