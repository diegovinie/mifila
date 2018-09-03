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

                $noti = $sim->probNotificable(15);

                $ticket = $queue->newTicket($client, $agency, $noti);
            }

            $prevised = $queue->getPrevisedTickets();
            // var_dump($prevised);die;
            $queue->notifyPrevisedTickets($prevised);

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
