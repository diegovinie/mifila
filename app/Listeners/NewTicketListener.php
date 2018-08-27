<?php

namespace App\Listeners;

use App\Events\NewTicket;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTicketListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewTicket  $event
     * @return void
     */
    public function handle(NewTicket $event)
    {
        //
        $ticket = $event->ticket;
    }
}
