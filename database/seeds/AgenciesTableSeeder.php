<?php

use Illuminate\Database\Seeder;
use App\Agency;

class AgenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Agency::create([
            'name' => 'Agencia Principal',
            'addr' => 'Calle 12 # 23b-90',
        ]);
    }
}
