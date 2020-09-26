<?php

use Faker\Generator as Faker;

$factory->define(App\Variable::class, function (Faker $faker) {
    return [
        'description' => $faker->name,
        'value' => $faker->randomNumber(2),
    ];
});
