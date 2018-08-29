<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['name', 'description', 'current_id'];
    //
    public function items()
    {
        return $this->hasMany('App\ConfigItem');
    }

    public function current()
    {
        return $this->belongsTo('App\ConfigItem');
    }

    public static function configsArray()
    {
        $response = [];
        $confs = self::with('current')->get();

        foreach ($confs as $conf) {
            // code...
            $response[$conf->name] = $conf->current->data;
        }

        return $response;
    }
}
