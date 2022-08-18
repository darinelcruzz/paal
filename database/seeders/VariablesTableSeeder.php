<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VariablesTableSeeder extends Seeder
{
    function run()
    {
        factory(\App\Variable::class)->create([
            'description' => 'exchange'
        ]);

        factory(\App\Variable::class)->create([
            'description' => 'hole'
        ]);
    }
}
