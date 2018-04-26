<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EgressModuleTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    function loads_the_view_of_egresses_for_coffee()
    {
        $user = factory(\App\User::class)->create([
        	'password' => 'paaltest',
        	'company' => 'coffee'
        ]);

        $this->actingAs($user)
        	->get(route('coffee.egress.index'))
        	->assertViewIs('coffee.egresses.index')
        	->assertStatus(200)
        	->assertSee('Egresos');
    }

    /** @test */
    function loads_the_view_of_egresses_for_mbe()
    {
        $user = factory(\App\User::class)->create([
        	'password' => 'paaltest',
        	'company' => 'mailboxes'
        ]);

        $this->actingAs($user)
        	->get(route('mbe.egress.index'))
        	->assertViewIs('mailboxes.egresses.index')
        	->assertStatus(200)
        	->assertSee('Egresos');
    }
}
