<?php

namespace Database\Factories;

use Faker\Generator as Faker;

$factory->define(App\State::class, function (Faker $faker) {
    return [
        'name' => 'Chiapas',
    ];
});
