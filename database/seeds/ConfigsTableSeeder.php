<?php

use Illuminate\Database\Seeder;
use App\Config;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'clients_rate' => 'Promedio de Clientes - array(24)',
            'acc' =>'Multiplicador de velocidad de clientes',
            'noti_prob' => 'Probabilidad de querer ser notificado',
        ];

        foreach ($types as $name => $desc) {
            // code...
            Config::create([
                'name' => $name,
                'description' => $desc
            ]);
        }

    }
}
