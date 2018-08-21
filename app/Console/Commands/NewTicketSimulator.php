<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NewTicketSimulator extends Command
{
    use TimeSimulatorTrait;

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
        $host = "http://localhost:8000/api/v1";
        $clientUrl = "clients/$cc";
        $ticketUrl = "tickets/create";

        $cmd1 = "curl $host/$clientUrl -s";
        // echo "$cmd1\n";
        $clientJson = shell_exec($cmd1);
        $client = json_decode($clientJson);

        if (!isset($client->name)) {

            $cmd2 = "curl $host/$clientUrl/generate -s";

            // echo "$cmd2\n";
            $clientJson = shell_exec($cmd2);
            $client = json_decode($clientJson);

            throw_unless(isset($client->name), new \Exception("No se pudo recuperar la identidad.\n"));
        }
        $client->agency_id = 1;
        $data = http_build_query($client);
        $cmd3 = "curl -d '$data' -X POST $host/$ticketUrl -s";
        // echo "$cmd3\n";
        $ticketJson = shell_exec($cmd3);
        $ticket = json_decode($ticketJson);

        if (!isset($ticket->num)) {
            var_dump($cmd3);
            var_dump($ticketJson);
            throw new \Exception('Nuevo ticket no recuperado.');
        }

        $this->timedOutput("Ticket {$ticket->num}: {$ticket->client->name} C.C. {$ticket->client->cc}");
    }

    protected function genCC()
    {
        $cc = mt_rand(20000000, 90000000);
        $variable = mt_rand(0, 99);
        $fixed = 80 * 1000 * 1000;

        return $fixed + $variable;
    }
}
