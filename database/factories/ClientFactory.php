<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'postcode' => $faker->postcode,
        'city' => $faker->city,
        'state' => $faker->state,
        'rfc' => $faker->regexify('[A-Z]{3}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z]{2}'),
        'phone' => $faker->phoneNumber,
        'email' => $faker->freeEmail,
        'company' => $faker->randomElement(array('mbe','coffee', 'sanson', 'both'))
    ];
});
