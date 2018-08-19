<?php

$dailyVel = array_fill(0, 24, 0);

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


mainLoop($dailyVel, 'goToQueue');

/////////////////////////////////////////////////
function goToQueue () {
    $host = "http://localhost:8000/ticket";
    $cc = mt_rand(20000000, 90000000);
    $gender = mt_rand(0, 10) > 6 ? 'M' : 'F';
    $data = http_build_query(compact('cc', 'gender'));
    $cmd = "'curl -X POST -d $data $host'";
    echo shell_exec($cmd)."\n";
    echo "$cmd\n";
}

function mainLoop ($rates, $action) {
    $top = 1000000;

    while (true) {
        $now = (new DateTime)->format('H');
        $a = $rates[(int)$now] * 100 * $top / 3600;
        echo "tratando a: $a\n";

        if(mt_rand(0, $top) < $a) {
            $action();
        }
        sleep(1);
    }
}
