<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }

    public function services()
    {
        return $this->hasMany('App\TicketService');
    }

    public function scopeIsPending($query)
    {
        return $query->wherePending(true);
    }

    public function scopeAvgWait($query, $minutes=10)
    {
        $now = new \DateTime;
        $interval = new \DateInterval("PT{$minutes}M");

        return $query->where('created_at', '>', $now->sub($interval))
                     ->avg('waited');
    }
}
