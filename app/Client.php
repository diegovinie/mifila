<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['cc', 'name', 'gender', 'priority'];
    
    protected $hidden = ['created_at', 'updated_at'];

    //
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function getCcAttribute()
    {
        return $this->id;
    }

    public function setCcAttribute($cc)
    {
        $this->id = $cc;
    }
}
