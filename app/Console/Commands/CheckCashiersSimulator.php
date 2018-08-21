<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Cashier;

class CheckCashiersSimulator extends Command
{
    use TimeSimulatorTrait;

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
        $cashiers = Cashier::all();
        $host = "http://localhost:8000/api/v1";

        foreach ($cashiers as $cashier) {
            // code...
            if ($cashier->idle) {
                $cmd = "curl $host/cashiers/{$cashier->id}/next -s";
                $output = shell_exec($cmd);
                $service = json_decode($output);
                try {
                    $this->timedOutput("$cashier->name libre, llamando a: {$service->ticket->num}\n");
                } catch (\Exception $e) {
                    new \Exception('No se puede recuperar datos del servicio.');
                }
            } else {
                // echo "$cashier->name Ocupado.\n";
            }
        }
    }
}
