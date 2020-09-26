<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductsTableSeeder extends Seeder
{
    function run()
    {
        factory(\App\Product::class, 20)->create([
            'company' => 'MBE',
            'barcode' => '',
    		'retail_price' => 0,
    		'wholesale_price' => 0,
    		'wholesale_quantity' => 0,
    		'is_variable' => 0,
    		'iva' => 0,
    		'dollars' => 0,
    		'is_summable' => 0,
            'family' => array_rand(['DHL', 'ESTAFETA', 'FEDEX', 'MBE LOCAL', 'REDPACK', 'COPIAS', 'IMPRESIONES', 'PAPELERIA', 'EMBALAJE', 'UPS']),
            'category' => 'MBE',
    		'minimum' => 0,
    		'quantity' => 0,
    		'features' => ''
        ]);

        // factory(\App\Product::class, 15)->create([
        //     'company' => 'COFFEE',
        //     'family' => $faker->randomElement(['DOSIFICADORES', 'LIMPIEZA', 'ACCESORIOS GENERAL', 'ACCESORIOS CAFE', 'BARRAS', 'BASES', 'JARABES', 'ESPECIAL', 'VITRINAS']),
        //     'category' => $faker->randomElement(['ACCESORIOS', 'EQUIPO', 'INSUMOS', 'SERVICIOS', 'VASOS', 'LIMPIEZA']),
    	// 	   'minimum' => 0,
    	// 	   'quantity' => 0,
    	// 	   'features' => ''
        // ]);

        // factory(\App\Product::class, 15)->create([
        //     'company' => 'SANSON',
        //     'family' => $faker->randomElement(['DOSIFICADORES', 'LIMPIEZA', 'ACCESORIOS GENERAL', 'ACCESORIOS CAFE', 'BARRAS', 'BASES', 'JARABES', 'ESPECIAL', 'VITRINAS']),
        //     'category' => $faker->randomElement(['ACCESORIOS', 'EQUIPO', 'INSUMOS', 'SERVICIOS', 'VASOS', 'LIMPIEZA']),
    	// 	   'minimum' => 0,
    	// 	   'quantity' => 0,
    	// 	   'features' => ''
        // ]);
    }
}
