<?php

namespace App\Listeners;

use App\Events\NewService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewServiceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewService  $event
     * @return void
     */
    public function handle(NewService $event)
    {
        //
    }
}
