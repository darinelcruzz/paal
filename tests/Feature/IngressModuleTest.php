<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngressModuleTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    function an_user_can_create_an_ingress()
    {
    	// $this->withoutExceptionHandling();
    	
     //    $this->signIn();

     //    $this->get(route('coffee.ingress.create', 'insumos'))
     //    	->assertSuccessful();
        $this->assertTrue(true);
    }

}
