<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    //
    public function cashiers()
    {
        return $this->hasMany('App\Cashier');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function services()
    {
        return $this->hasMany('App\TicketService');
    }
}
