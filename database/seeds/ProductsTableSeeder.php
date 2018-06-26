<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    function run()
    {
        factory(\App\Product::class, 10)->create();
    }
}
