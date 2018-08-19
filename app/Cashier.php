<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    //
    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }

    public function services()
    {
        return $this->hasMany('App\TicketService');
    }

    public function nextTicket()
    {
        $ticket = $this->agency->tickets()->isPending()->first();

        if (!$ticket) {
            return null;
        }

        $ticket->pending = false;
        $ticket->save();

        return $ticket;
    }

    public function getIdleAttribute()
    {
        $busy = $this->services()->notFinished()->first();

        return !$busy ? true : false;
    }
}
