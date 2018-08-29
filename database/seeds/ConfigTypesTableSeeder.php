<?php

use Illuminate\Database\Seeder;
use App\ConfType as Type;

class ConfigTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'clients1' => 'Promedio de Clientes - array(24)',
            'cashiers1' => 'Horario de Cajeros',
            'agencies1' => 'Horario de Agencia',
        ];

        foreach ($types as $ref => $name) {
            // code...
            Type::create([
                'name' => $name,
                'ref' => $ref
            ]);
        }
    }
}
