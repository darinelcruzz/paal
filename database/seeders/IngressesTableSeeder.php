<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IngressesTableSeeder extends Seeder
{
    function run()
    {
        factory(\App\Ingress::class, 10)->create();
    }
}
