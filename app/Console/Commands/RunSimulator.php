<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

    protected $top = 1000;

    protected $acc;

    protected $vel;

    protected $dailyVel;

    protected $constVel;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->dailyVel = array_fill(0, 24, 0);
        $this->constVel = array_fill(0, 24, 30);

        $this->dailyVel[7] =  15;
        $this->dailyVel[8] =  80;
        $this->dailyVel[9] =  55;
        $this->dailyVel[10] = 30;
        $this->dailyVel[11] = 25;
        $this->dailyVel[12] = 70;
        $this->dailyVel[13] = 85;
        $this->dailyVel[14] = 60;
        $this->dailyVel[15] = 20;
        $this->dailyVel[16] = 30;
        $this->dailyVel[17] = 5;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkConnection();

        $titleSwitch = true;
        $this->acc = $this->argument('acc');

        while (true) {

            $probNewTicket = $this->probability();
            $prob = number_format($probNewTicket / $this->top, 4);

            if ($titleSwitch) {
                echo "[{$this->timeFormated()}] Vel: $this->vel p/h, acc: $this->acc veces, prob: $prob\n\n";
                $titleSwitch = false;
            }

            if(mt_rand(0, $this->top) < $probNewTicket) {
                $this->call('simulator:ticket');
            }
            $this->call('simulator:check');

            sleep(1);
        }
    }

    protected function checkConnection()
    {
        $url = route('api.ping');
        $out = shell_exec("curl $url -i -s");
        $hostup = preg_match("/200 OK/", $out);
        if (!$hostup) {
            throw new \Exception('No se puede contactar con el servidor');
        }
    }

    protected function probability($constRate=false)
    {
        $rates = $constRate ? $this->dailyVel : $this->constVel;

        $this->now = new \DateTime;
        $this->vel = $rates[(int)$this->now->format('H')];

        return $this->vel * $this->acc * $this->top / 3600;
    }
}
