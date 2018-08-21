<?php

namespace App\Console\Commands;

trait TimeSimulatorTrait
{

    protected function timeFormated()
    {
        return (new \DateTime)->format('h:i:s d/m/Y');
    }

    protected function timedOutput($output)
    {
        echo "[{$this->timeFormated()}] $output\n";
    }
}
