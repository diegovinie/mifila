<?php

namespace App\Listeners;

use App\Events\NotifyTicket;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\PreventClientMail;
use Mail;

class NotifyTicketListener
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
     * @param  NotifyTicket  $event
     * @return void
     */
    public function handle(NotifyTicket $event)
    {
        //
        $ticket = $event->ticket;
        $client = $event->ticket->client;

        if ($client->phone) {

        }

        if ($email = $client->email) {
            Mail::to($email)->send(new PreventClientMail($ticket));
        }
    }
}
