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

            $probNewTicket = $sim->probability(true);

            if(mt_rand(0, $sim->top) < $probNewTicket) {

                $cc = Simulator::genCC();

                $client = $queue->clientFromCC($cc);

                if (!isset($client->name)) {

                    $client = Simulator::generateIdentity($cc);
                    $client->save();

                    if (!$client) {
                        return;
                    }
                }

                $agency = $agencies[mt_rand(0, count($agencies) - 1)];

                if (!($agency instanceof \App\Agency)) {
                    echo "Problemas con la agencia.\n";
                    return;
                }

                $ticket = $queue->newTicket($client, $agency);
            }

            sleep(1);
        }
    }
}
