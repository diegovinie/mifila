<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NewTicketSimulator extends Command
{
    use TimeSimulatorTrait, LogsSimulatorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulator:ticket';

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
        $cc = $this->genCC();
        $clientUrl = route('api.clients.show', $cc);
        // $ticketUrl = route('api.tickets.store');

        $clientJson = shell_exec("curl $clientUrl -s");
        $client = json_decode($clientJson);

        if (!isset($client->name)) {

            $client = $this->getIdentity($cc);

            if (!$client) {
                return;
            }
        }

        $agencies = \App\Agency::all();
        $agency = $agencies[mt_rand(0, count($agencies) - 1)];

        if (!($agency instanceof \App\Agency)) {
            echo "Problemas con la agencia.\n";
            return;
        }

        $ticketUrl = route('api.tickets.store', $agency->id);

        // $client->agency_id = 1;
        $data = http_build_query($client);

        $ticketJson = shell_exec("curl -d '$data' -X POST $ticketUrl -s");
        $ticket = json_decode($ticketJson);

        if (!isset($ticket->num)) {
            $this->saveLog('newTicket', $ticketJson);
            throw new \Exception('Nuevo ticket no recuperado.');
        }

        $this->timedOutput("En {$agency->name} Ticket {$ticket->num}: {$ticket->client->name} C.C. {$ticket->client->cc}");
    }

    protected function genCC()
    {
        $cc = mt_rand(20000000, 90000000);
        $variable = mt_rand(0, 99);
        $fixed = 80 * 1000 * 1000;

        return $fixed + $variable;
    }

    protected function getIdentity($cc, $times=0)
    {
        $getIdentUrl = route('api.sim.gen.client', $cc);

        $clientJson = shell_exec("curl $getIdentUrl -s");
        $client = json_decode($clientJson);

        if (!isset($client->name)) {
            if ($times > 2) {
                $this->timedOutput("No se pudo recuperar la identidad de $cc en $times intentos.");
                $this->saveLog('getIdentity', $clientJson);
                return null;
            }
            $this->getIdentity($cc, ++$times);
        }

        return $client;
    }
}
