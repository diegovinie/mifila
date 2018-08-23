<?php

namespace App\Library;

use App\Client;

class Simulator
{

    public static function generateIdentity($cc)
    {
        $client = factory(Client::class)->make();
        $client->cc = (int)$cc;

        return $client;
    }
}
