<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EgressesTableSeeder extends Seeder
{
    function run()
    {
        factory(\App\Egress::class, 10)->create();
    }
}
