<?php

use Faker\Generator as Faker;

$factory->define(App\Cashier::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName() . ' ' . $faker->lastName(),
        'rate' => mt_rand(30, 150),
        'active' =>  mt_rand(0, 9) < 8 ? true : false,
    ];
});
