<?php

namespace App\Observers;
use App\Client;

class ClientObserver
{
   public function creating(Client $client)
   {
       $client->id = $client->cc;
   }
}
