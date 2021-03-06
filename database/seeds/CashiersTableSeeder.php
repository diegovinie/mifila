<?php

use Illuminate\Database\Seeder;
use App\Cashier;

class CashiersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cashier::create([
            'name' => 'Pedro Perez',
            'agency_id' => 1,
            'rate' => 70,
        ]);

        Cashier::create([
            'name' => 'Ana Jiménez',
            'agency_id' => 1,
            'rate' => 105,
        ]);
    }
}
