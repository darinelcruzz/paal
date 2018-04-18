<?php

use Illuminate\Database\Seeder;

class CoffeeProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Coffee\CProvider::class, 7)->create();
    }
}
