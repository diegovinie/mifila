<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    $phone = function () {
        return '30'.(string)mt_rand(10000000, 99999999);
    };

    $gender = mt_rand(0, 9) < 5 ? 'male' : 'female';

    $prob = function (int $perc) {
        return mt_rand(0, 100) < $perc;
    };

    return [
        'cc' => mt_rand(20000000, 90000000),
        'name' => $faker->firstName($gender) . ' ' . $faker->lastName(),
        'gender' => $gender,
        'phone' => $prob(30) ? $phone() : null,
        'email' => $prob(60) ? $faker->email() : null,
        'priority' => $prob(15) ? true : false,
    ];
});
