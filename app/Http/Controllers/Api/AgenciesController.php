<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agency;

class AgenciesController extends Controller
{
    //
    public function all($id)
    {
        $agency = Agency::findOrFail($id);
        $name = $agency->name;
        $queue = $this->queue($id);
        $cashiers = $this->cashiers($id);
        $finished = $this->finished($id);
        $avg = $this->avg($id);

        return response()->json(compact(
            'queue',
            'cashiers',
            'finished',
            'avg',
            'name'
        ));
    }

    public function queue($id)
    {
        $agency = Agency::findOrFail($id);

        return $agency->tickets()->isPending()->count();
    }

    public function cashiers($id)
    {
        $agency = Agency::findOrFail($id);

        return $agency->cashiers()->isActive()->count();
    }

    public function finished($id)
    {
        $agency = Agency::findOrFail($id);

        return $agency->services()->finishedToday()->count();
    }

    public function avg($id)
    {
        $agency = Agency::findOrFail($id);

        try {
            return (int)$agency->tickets()->avgWait();

        } catch (\Exception $e) {
            return 0;
        }
    }
}
