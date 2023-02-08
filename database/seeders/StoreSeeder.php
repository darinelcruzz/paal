<?php

namespace Database\Seeders;

use App\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::factory()->create([
            'name' => 'Matriz',
            'company_id' => 1,
        ]);

        Store::factory()->create([
            'name' => 'Matriz',
            'company_id' => 2,
        ]);

        Store::factory()->create([
            'name' => 'Matriz',
            'company_id' => 3,
        ]);

        Store::factory()->create([
            'name' => 'Mérida',
            'company_id' => 2,
        ]);
    }
}
