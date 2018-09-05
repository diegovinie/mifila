<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketService extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function cashier()
    {
        return $this->belongsTo('App\Cashier');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }

    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }

    public function scopeNotFinished($query)
    {
        $now = new \DateTime;

        return $query->where('due', '>', $now);
    }

    public function scopeFinishedToday($query)
    {
        $now = (new \DateTime)->format('Y-m-d');
        $today = new \DateTime($now);

        return $query->where('created_at', '>', $today);
    }
}
