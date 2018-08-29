<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigItem extends Model
{
    protected $fillable = ['name', 'data', 'description'];
    //
    public function config()
    {
        return $this->belongsTo('App\Config');
    }
}
