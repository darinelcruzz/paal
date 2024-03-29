<?php

namespace Database\Factories;

use Faker\Generator as Faker;

$factory->define(App\Ingress::class, function (Faker $faker) {
	$lastWeek = time() - (7 * 24 * 60 * 60);
	$randomTime = mt_rand($lastWeek, time());

    return [
    	'client_id' => factory(App\Client::class),
        'user_id' => factory(App\Client::class),
    	'products' => function () {
    		$toBeSerialized = [];
    		$products = App\Product::take(3)->get();
    		foreach ($products as $product) {
    			$quantity = random_int(5, 50);
    			$price = $quantity >= $product->wholesale_quantity ? $product->wholesale_price: $product->retail_price;
    			array_push($toBeSerialized, [
    				'i' => $product->id,
    				'q' => $quantity,
    				'p' => $price,
    				't' => $quantity * $price,
    			]);
    		}
    		return serialize($toBeSerialized);
    	},
        'bought_at' => date('Y-m-d', $randomTime),
        'company' => 'coffee',
        'status' => 'pendiente',
        'amount' => 1000.00,
        'iva' => 160.00
    ];
});
