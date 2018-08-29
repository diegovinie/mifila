<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['name', 'data', 'description'];
    //
    public function type()
    {
        return $this->belongsTo('App\ConfType');
    }
}
