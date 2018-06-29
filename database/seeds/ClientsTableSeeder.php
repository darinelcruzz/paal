<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        factory(\App\Client::class)->create();
    }
}
