<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\NewTicket' => [
            'App\Listeners\NewTicketListener',
        ],
        'App\Events\NewService' => [
            'App\Listeners\NewServiceListener'
        ],
        'App\Events\UpdateGlobals' => [

        ],
        'App\Events\UpdateAgency' => [
            
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
