<?php

use Illuminate\Database\Seeder;
use App\Config;
use App\ConfType as Type;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $arate = array_fill(0, 24, 0);
        $consRate = array_fill(0, 24, 30);

        $arate[7] =  15;
        $arate[8] =  80;
        $arate[9] =  55;
        $arate[10] = 30;
        $arate[11] = 25;
        $arate[12] = 70;
        $arate[13] = 85;
        $arate[14] = 60;
        $arate[15] = 20;
        $arate[16] = 30;
        $arate[17] = 5;

        $conf1 = Config::make([
            'name' => 'Clientes constantes',
            'data' => json_encode($consRate)
        ]);


        $conf2 = Config::make([
            'name' => 'Clientes A',
            'data' =>  json_encode($arate)
        ]);

        $clientType = Type::whereRef('clients1')->first();

        $conf1->type()->associate($clientType);
        $conf2->type()->associate($clientType);

        $conf1->save();
        $conf2->save();
    }
}
