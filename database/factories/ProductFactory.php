<?php

namespace Database\Factories;

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
	$retail_price = $faker->randomNumber(2);
	$dollar = $faker->randomElement([0, 1]);
	$iva = $dollar ? 1 : $faker->randomElement([0, 1]);
	$summable = $dollar ? 0 : $faker->randomElement([0, 1]);

    return [
        'description' => $faker->company,
        'code' => $faker->swiftBicNumber,
        'barcode' => $faker->swiftBicNumber,
		'retail_price' => $retail_price,
		'wholesale_price' => $retail_price / 2,
		'wholesale_quantity' => $faker->randomElement(array (20, 50, 100, 200)),
		'is_variable' => $faker->randomElement([0, 1]),
		'iva' => $iva,
		'dollars' => $dollar,
		'is_summable' => $summable,
        'family' => $faker->randomElement(['limpieza', 'plomería', 'jardinería', 'papelería']),
        'category' => $faker->randomElement(['limpieza', 'plomería', 'jardinería', 'papelería']),
        'company' => $faker->randomElement(['MBE', 'COFFEE', 'SANSON']),
		'minimum' => $faker->randomNumber(1),
		'quantity' => $faker->randomNumber(2),
		'features' => $faker->text(20)
    ];
});
