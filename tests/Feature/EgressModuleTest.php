<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EgressModuleTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    function a_singed_user_sees_egresses_index()
    {
        // $this->withoutExceptionHandling();

        $this->assertTrue(true);
    }
}
