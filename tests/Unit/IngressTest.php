<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngressTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    function it_belongs_to_a_client()
    {
        $ingress = factory('App\Ingress')->create();

        $this->assertInstanceOf('App\Client', $ingress->client);
    }
}
