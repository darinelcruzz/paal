<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'city' => $faker->city,
        'phone' => $faker->phoneNumber,
        'email' => $faker->freeEmail
    ];
});
