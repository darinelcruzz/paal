<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProviderModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function loads_the_view_of_providers_for_paal()
    {
        $user = factory(\App\User::class)->create([
        	'password' => 'paaltest',
        	'company' => 'paal'
        ]);

        $this->actingAs($user)
        	->get(route('paal.provider.index'))
        	->assertViewIs('paal.providers.index')
        	->assertStatus(200)
        	->assertSee('Proveedores');
    }
}
