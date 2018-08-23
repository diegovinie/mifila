<?php

namespace App\Library;

use App\Client;

class Simulator
{
    public $top = 1000;

    public $acc = 60;

    public $vel;

    protected $dailyVel;

    protected $constVel;

    public function __construct()
    {
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

    public static function generateIdentity($cc)
    {
        $client = factory(Client::class)->make();
        $client->cc = (int)$cc;

        return $client;
    }

    public static function genCC()
    {
        $cc = mt_rand(20000000, 90000000);
        $variable = mt_rand(0, 99);
        $fixed = 80 * 1000 * 1000;

        return $fixed + $variable;
    }

    public function probability($constRate=false)
    {
        $rates = !$constRate ? $this->dailyVel : $this->constVel;

        $this->now = new \DateTime;
        $this->vel = $rates[(int)$this->now->format('H')];

        return $this->vel * $this->acc * $this->top / 3600;
    }
}
