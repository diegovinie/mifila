<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ticket;

class PreventClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    public $client;

    public $agency;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        //
        $this->ticket = $ticket;
        $this->client = $ticket->client;
        $this->agency = $ticket->agency;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.prevent')->subject("Se cerca su turno {$this->ticket->num}");
    }
}
