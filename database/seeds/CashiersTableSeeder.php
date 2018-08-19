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
        ]);
    }
}
