<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'cc' => 1127606049,
            'name' => 'Diego Viniegra',
            'gender' => 'male',
            'phone' => '3507896384',
            'email' => 'diego.viniegra@gmail.com',
            'previse' => 180,
        ]);
    }
}
