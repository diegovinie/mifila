<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketService extends Model
{
    //
    public function cashier()
    {
        return $this->belongsTo('App\Cashier');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
}
