<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\Library\Simulator;

class ClientsController extends Controller
{
    //
    public function show($cc)
    {
        $client = Client::find($cc);

        if (!$client) {
            return response()->json(null, 404);
        }

        return $client;
    }

    public function list()
    {
        return Client::all();
    }

    public function generateIdentity($cc)
    {
        return Simulator::generateIdentity($cc);
    }

    // public function generateIdentitybk($cc)
    // {
    //     $client = factory(Client::class)->make();
    //     $client->cc = (int)$cc;
    //
    //     return $client;
    // }
}
