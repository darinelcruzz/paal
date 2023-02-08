<?php

namespace Database\Seeders;

use App\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            'PAAL', 'COCINASPAAL', 'LOGISTICAPAAL',
        ];

        foreach ($companies as $company) {
            Company::factory()->create(['name' => $company]);
        }
    }
}
