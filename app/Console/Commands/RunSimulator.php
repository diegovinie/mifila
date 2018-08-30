<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Simulator;
use App\Library\QueueManager;

class RunSimulator extends Command
{
    use TimeSimulatorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulator:run {acc=2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corre el simulador.';



    /**
     * Create a new command instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->dailyVel = array_fill(0, 24, 0);
    //     $this->constVel = array_fill(0, 24, 30);
    //
    //     $this->dailyVel[7] =  15;
    //     $this->dailyVel[8] =  80;
    //     $this->dailyVel[9] =  55;
    //     $this->dailyVel[10] = 30;
    //     $this->dailyVel[11] = 25;
    //     $this->dailyVel[12] = 70;
    //     $this->dailyVel[13] = 85;
    //     $this->dailyVel[14] = 60;
    //     $this->dailyVel[15] = 20;
    //     $this->dailyVel[16] = 30;
    //     $this->dailyVel[17] = 5;
    // }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(QueueManager $queue, Simulator $sim)
    {
        // $this->checkConnection();

        $titleSwitch = true;
        // $sim->acc = $this->argument('acc');

        while (true) {

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

            // $probNewTicket = $sim->probability(true);
            // $prob = number_format($probNewTicket / $sim->top, 4);
            //
            // if ($titleSwitch) {
            //     echo "[{$this->timeFormated()}] Vel: $sim->vel p/h, acc: $sim->acc veces, prob: $prob\n\n";
            //     $titleSwitch = false;
            // }
            //
            // if(mt_rand(0, $sim->top) < $probNewTicket) {
            //     $this->call('simulator:ticket');
            // }
            // $this->call('simulator:check');

            sleep(1);
        }
    }

    // public function handlebk()
    // {
    //     $this->checkConnection();
    //
    //     $titleSwitch = true;
    //     $this->acc = $this->argument('acc');
    //
    //     while (true) {
    //
    //         $probNewTicket = $this->probability();
    //         $prob = number_format($probNewTicket / $this->top, 4);
    //
    //         if ($titleSwitch) {
    //             echo "[{$this->timeFormated()}] Vel: $this->vel p/h, acc: $this->acc veces, prob: $prob\n\n";
    //             $titleSwitch = false;
    //         }
    //
    //         if(mt_rand(0, $this->top) < $probNewTicket) {
    //             $this->call('simulator:ticket');
    //         }
    //         $this->call('simulator:check');
    //
    //         sleep(1);
    //     }
    // }
    //
    // protected function checkConnection()
    // {
    //     $url = route('api.ping');
    //     $out = shell_exec("curl $url -i -s");
    //     $hostup = preg_match("/200 OK/", $out);
    //     if (!$hostup) {
    //         throw new \Exception('No se puede contactar con el servidor');
    //     }
    // }
    //
    // protected function probability($constRate=false)
    // {
    //     $rates = $constRate ? $this->dailyVel : $this->constVel;
    //
    //     $this->now = new \DateTime;
    //     $this->vel = $rates[(int)$this->now->format('H')];
    //
    //     return $this->vel * $this->acc * $this->top / 3600;
    // }
}
