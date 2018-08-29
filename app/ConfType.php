<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfType extends Model
{
    public $timestamps = false;
    //
    public function configs()
    {
        return $this->hasMany('App\Config');
    }
}
