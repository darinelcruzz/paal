<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

$factory->define(App\Egress::class, function (Faker $faker) {
	$lastWeek = time() - (7 * 24 * 60 * 60);
	$randomTime = mt_rand($lastWeek, time());
	$amount = $faker->randomFloat(2, 5000, 15000);
	$bought_at = date('Y-m-d', $randomTime);
	$files = Storage::files('public/coffee/bills');

    return [
        'provider_id' => function () {
    		return factory(App\Provider::class)->create()->id;
    	},
        'pdf_bill' => $files[0],
        'pdf_payment' => $files[0],
        'xml' => $files[1],
        'amount' => $amount,
        'iva' => $amount * 0.16,
        'emission' => $bought_at,
        'expiration' => date('Y-m-d', $randomTime + mt_rand(2, 10) * 24 * 60 * 60),
        'folio' => $faker->randomNumber(4),
        'status' => 'pendiente',
        'company' => $faker->randomElement(array ('coffee','mbe')),
    ];
});
