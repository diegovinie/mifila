<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    $phone = function () {
        return '30'.(string)mt_rand(10000000, 99999999);
    };

    $gender = mt_rand(0, 9) < 5 ? 'male' : 'female';

    return [
        'cc' => mt_rand(20000000, 90000000),
        'name' => $faker->firstName($gender) . ' ' . $faker->lastName(),
        'gender' => $gender,
        'phone' => mt_rand(0, 9) < 3 ? $phone() : null,
        'priority' => mt_rand(0, 9) < 1 ? true : false,
    ];
});
