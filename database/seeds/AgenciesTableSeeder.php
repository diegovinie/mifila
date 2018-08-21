<?php

use Illuminate\Database\Seeder;
use App\Agency;
use App\Cashier;

class AgenciesTableSeeder extends Seeder
{
    protected $numCashiers = 3;
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

        factory(Agency::class, 2)->create()->each(function ($agency) {
            for ($i=0; $i < $this->numCashiers; $i++) {
                $agency->cashiers()->save(factory(Cashier::class)->make());
            }
        });
    }
}
