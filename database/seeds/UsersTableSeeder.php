<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('helefante'),
            'company' => 'owner'
        ]);

        factory(\App\User::class)->create([
            'name' => 'Héctor Palacios',
            'username' => 'hpalacios22',
            'password' => Hash::make('titoBB19'),
            'company' => 'owner'
        ]);
    }
}
