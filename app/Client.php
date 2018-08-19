<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['cc', 'name', 'gender', 'priority'];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    //
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
