<?php

$dailyVel = array_fill(0, 24, 0);
$constVel = array_fill(0, 24, 30);

$dailyVel[7] =  15;
$dailyVel[8] =  80;
$dailyVel[9] =  55;
$dailyVel[10] = 30;
$dailyVel[11] = 25;
$dailyVel[12] = 70;
$dailyVel[13] = 85;
$dailyVel[14] = 60;
$dailyVel[15] = 20;
$dailyVel[16] = 30;
$dailyVel[17] = 5;
/////////////////////////////////////////////////


// mainLoop($dailyVel, 'goToQueue');
mainLoop($constVel, 'goToQueue');

/////////////////////////////////////////////////
function goToQueue () {
    $cc = genCC();
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
    }
    $client->agency_id = 1;
    $data = http_build_query($client);
    $cmd3 = "curl -d '$data' -X POST $host/$ticketUrl -s";
    // echo "$cmd3\n";
    $ticketJson = shell_exec($cmd3);
    $ticket = json_decode($ticketJson);
    echo "Ticket {$ticket->num}: {$ticket->client->name} C.C. {$ticket->client->cc} creado: {$ticket->created_at}\n";
}

function genCC () {
    $cc = mt_rand(20000000, 90000000);
    $variable = mt_rand(0, 99);
    $fixed = 80 * 1000 * 1000;

    return $fixed + $variable;
}

function mainLoop ($rates, $action) {
    $top = 1000 * 1000;
    $acc = 50;

    while (true) {
        $now = new DateTime;
        $vel = $rates[(int)$now->format('H')];
        $a = $vel * $acc * $top / 3600;
        $prob = number_format($a / $top, 4);

        echo "[{$now->format('h:i:s d/m/Y')}] Vel: $vel p/h, acc: $acc veces, prob: $prob\n";

        if(mt_rand(0, $top) < $a) {
            $action();
        }
        sleep(1);
    }
}
