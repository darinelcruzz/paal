<?php

use Faker\Generator as Faker;

$factory->define(App\City::class, function (Faker $faker) {
    return [
        'name' => 'tuxtla gutiérrez',
        'state_id' => 4,
    ];
});
