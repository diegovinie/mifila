<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Library\QueueManager;
use App\Library\Simulator;

class TicketServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Ticket::observe(\App\Observers\TicketObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QueueManager::class, function ($app) {
            return new QueueManager();
        });

        $this->app->bind(Simulator::class, function ($app) {
            return new Simulator();
        });
    }
}
