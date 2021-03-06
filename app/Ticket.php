<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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

    public function scopeToNotify($query)
    {
        return $query->isPending()->whereNotifiable(true)->whereNotified(false);
    }

    public function scopeAvgWait($query)
    {
        return (int)$query->latest()->wherePending(false)
            ->limit(10)->avg('waited');

    }

    public function scopeAvgWaitbk($query, $minutes=20)
    {
        $now = new \DateTime;
        $interval = new \DateInterval("PT{$minutes}M");

        return $query->where('created_at', '>', $now->sub($interval))
                     ->avg('waited');
    }

    public function getNotifiableAttribute($value)
    {
        return (int)$value;
    }

    public function getNotifiedAttribute($value)
    {
        return (int)$value;
    }
}
