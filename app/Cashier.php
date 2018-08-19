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
}
