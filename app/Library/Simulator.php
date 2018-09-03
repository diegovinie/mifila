<?php

namespace App\Library;

use App\Client;
use App\Config;
use App\Agency;

class Simulator
{
    public $top = 1000;

    public $acc;

    public $vel;

    public $clients_rate;

    public function __construct()
    {
        $this->loadConfig();
    }

    public function loadConfig()
    {
        $configs = Config::configsArray();

        foreach ($configs as $key => $value) {
            // code...
            $this->$key = json_decode($value, true);
        }
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

    public function probability()
    {
        // $rates = !$constRate ? $this->dailyVel : $this->constVel;
        $rates = $this->clients_rate;

        $this->now = new \DateTime;
        $this->vel = $rates[(int)$this->now->format('H')];

        return $this->vel * $this->acc * $this->top / 3600;
    }

    public function probNotificable($prob)
    {
        return mt_rand(0, 99) < $prob ? true : false;
    }

    public function pickAgency($agencies)
    {
        $agency = $agencies[mt_rand(0, count($agencies) - 1)];

        if (!($agency instanceof Agency)) {
            echo "Problemas con la agencia.\n";
            return;
        }
        return $agency;
    }

    public function newTicket()
    {
        return mt_rand(0, $this->top) < $this->probability();
    }
}
