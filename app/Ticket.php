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

}
