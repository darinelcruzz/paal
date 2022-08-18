<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        factory(\App\Client::class)->create([
        	'name' => 'CLIENTE MOSTRADOR',
        	'company' => 'both'
        ]);
        factory(\App\Client::class, 3)->create([
            'company' => 'mbe'
        ]);
        factory(\App\Client::class, 3)->create([
            'company' => 'coffee'
        ]);
        factory(\App\Client::class, 3)->create([
            'company' => 'sanson'
        ]);
    }
}
