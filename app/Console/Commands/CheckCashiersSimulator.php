<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Cashier;
use App\Agency;

class CheckCashiersSimulator extends Command
{
    use TimeSimulatorTrait, LogsSimulatorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulator:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Un cliente toma un nuevo ticket.';

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
    public function handle()
    {
        $agencies = Agency::all();
        // $cashiers = Cashier::all();

        foreach ($agencies as $agency) {
            // code...
            $cashiers = $agency->cashiers()->get();

            foreach ($cashiers as $cashier) {
                // code...
                if ($cashier->idle) {
                    $url = route('api.cashiers.next', $cashier->id);
                    $output = shell_exec("curl $url -s");
                    $service = json_decode($output);

                    try {
                        if (isset($service->status) && $service->status == 'empty') {
                            continue;
                        }

                        $this->timedOutput("En $agency->name el cajero $cashier->name libre, llamando a: {$service->ticket->num}\n");

                    } catch (\Exception $e) {
                        // var_dump($output);
                        echo "$cashier->name de $agency->name no se puede recuperar datos del servicio.\n";
                    }
                } else {
                    // echo "$cashier->name Ocupado.\n";
                }
            }
        }
    }
}
