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
            'username' => 'lab3',
            'password' => Hash::make('helefante'),
            'company' => 'owner'
        ]);

        factory(\App\User::class)->create([
        	'username' => 'coffee',
        	'password' => Hash::make('coffeed'),
        	'company' => 'coffee'
        ]);

        factory(\App\User::class)->create([
        	'username' => 'paal',
        	'password' => Hash::make('paypaal'),
        	'company' => 'paal'
        ]);

        factory(\App\User::class)->create([
        	'username' => 'mailbox',
        	'password' => Hash::make('malebox'),
        	'company' => 'mailboxes'
        ]);
    }
}
