<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\QueueManager;
use App\Library\Simulator;

class CronSimulator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulator:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Correr el simulador desde el crontab.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(QueueManager $queue, Simulator $sim)
    {
        $active = env('APP_SIM', false);
        if (!$active) {
            return;
        }

        for ($i=0; $i < 59; $i++) {

            $agencies = \App\Agency::all();

            foreach ($agencies as $agency) {

                $cashiers = $agency->cashiers()->get();

                foreach ($cashiers as $cashier) {

                    if ($cashier->idle) {

                        $service = $queue->cashierCalls($cashier);
                        // var_dump($service);
                        if (!$service) {
                            continue;
                        }
                    }
                }
            }

            if($sim->newTicket()) {

                $cc = Simulator::genCC();

                $client = $queue->clientFromCC($cc);

                if (!isset($client->name)) {

                    $client = Simulator::generateIdentity($cc);
                    $client->save();

                    if (!$client) {
                        return;
                    }
                }

                $agency = $sim->pickAgency($agencies);

                $noti = $this->probNotificable(15);

                $ticket = $queue->newTicket($client, $agency, $noti);
            }

            sleep(1);
        }
    }
}
