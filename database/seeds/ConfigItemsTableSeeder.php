<?php

use Illuminate\Database\Seeder;
use App\ConfigItem as Item;
use App\Config;

class ConfigItemsTableSeeder extends Seeder
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

        $conf1 = Item::make([
            'name' => 'Clientes constantes',
            'data' => json_encode($consRate)
        ]);


        $conf2 = Item::make([
            'name' => 'Clientes A',
            'data' =>  json_encode($arate)
        ]);

        $clientType = Config::whereName('clients_rate')->first();

        $conf1->config()->associate($clientType);
        $conf2->config()->associate($clientType);

        $conf1->save();
        $conf2->save();



        /* ACELERACIONES */

        $accs = [1, 2, 5, 10, 20, 50, 100];
        $accType = Config::whereName('acc')->first();

        foreach ($accs as $value) {
            $acc = Item::make([
                'name' => "x{$value}",
                'data' => $value
            ]);

            $acc->config()->associate($accType);
            $acc->save();
            $acc = null;
        }

        /* Probabilidad de querer ser notificado */

        $probs = [0, 1, 2, 3, 5, 7, 10, 12, 15, 20];
        $notiType = Config::whereName('noti_prob')->first();

        foreach ($probs as $prob) {
            $noti = Item::make([
                'name' => "{$prob} %",
                'data' => $prob
            ]);

            $noti->config()->associate($notiType);
            $noti->save();
            $noti = null;
        }

        /* FIJANDO LAS CONFIGURACIONES POR DEFECTO */

        $cliRateConf = Config::whereName('clients_rate')->first();
        $cliRateConf->current_id = 1;
        $cliRateConf->save();

        $accConf = Config::whereName('acc')->first();
        $accConf->current_id = 6;
        $accConf->save();

        $notiType->current_id = 10;
        $notiType->save();
    }
}
