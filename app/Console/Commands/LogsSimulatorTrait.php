<?php

namespace App\Console\Commands;

trait LogsSimulatorTrait
{
    public function getPath()
    {
        return 'storage/logs';
    }

    public function saveLog($type, $content)
    {
        $path = $this->getPath();
        \File::put("$path/$type.log", $content);
    }
}
