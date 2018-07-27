<?php

use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{
    function run()
    {
        factory(\App\Provider::class, 3)->create();
    }
}
