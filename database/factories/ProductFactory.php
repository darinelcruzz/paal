<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
	$retail_price = $faker->randomNumber(2);

    return [
        'description' => $faker->company,
        'code' => $faker->swiftBicNumber,
        'family' => $faker->randomElement(['limpieza', 'plomería', 'jardinería', 'papelería']),
        'iva' => $faker->randomElement([0, 1]),
        'is_variable' => $faker->randomElement([0, 1]),
        'dollars' => $faker->randomElement([0, 1]),
        'wholesale_price' => $retail_price / 2,
        'retail_price' => $retail_price,
        'wholesale_quantity' => $faker->randomElement(array (20, 50, 100, 200)),
    ];
});