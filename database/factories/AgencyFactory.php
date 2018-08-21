<?php

use Faker\Generator as Faker;

$factory->define(App\Agency::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'addr' => $faker->address,
    ];
});
