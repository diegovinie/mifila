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
        if ($this->active) {
            $ticket = $this->agency->tickets()->isPending()->first();

            if (!$ticket) {
                return null;
            }

            $ticket->pending = false;
            $ticket->save();

            return $ticket;
        }
        return null;
    }

    public function getIdleAttribute()
    {
        $busy = $this->services()->notFinished()->first();

        return !$busy ? true : false;
    }

    public function scopeIsActive($query)
    {
        return $query->where('active', true);
    }

    public function getActiveAttribute($value)
    {
        return (int)$value;
    }

    public function getCurrentAttribute()
    {
        if (!$service = $this->services()->latest()->notFinished()->first()) {
            return null;
        }

        return $service->ticket->num;
    }
}
