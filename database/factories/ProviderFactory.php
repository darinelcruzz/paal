<?php

use Faker\Generator as Faker;

$factory->define(App\Provider::class, function (Faker $faker) {
    return [
        'social' => "{$faker->company} {$faker->companySuffix}",
        'name' => $faker->jobTitle,
        'rfc' => $faker->regexify('[A-Z]{3}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z]{2}'),
        'address' => $faker->address,
        'email' => $faker->freeEmail,
        'contact' => $faker->name,
        'phone' => $faker->tollFreePhoneNumber,
        'type' => $faker->randomElement(array('cv','gg')),
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'company' => $faker->randomElement(array('mbe','coffee', 'both')),
   ];
});
