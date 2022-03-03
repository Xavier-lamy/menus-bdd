<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class FrontTest extends TestCase
{
    /**
     * Test front view
     *
     * @return void
     */
    public function testFrontView()
    {
        $user = new User();

        $response = $this->actingAs($user)->get('/');

        $response->assertViewIs('front');
    }

    /**
     * Test front route 
     *
     * @return void
     */
    public function testFrontRoute()
    {
        $user = new User();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test only authenticated user can access to front view
     * 
     * @test
     * @return void
     */
    public function onlyAuthenticatedUserCanAccessFront()
    {
        $response = $this->get('/');

        $response->assertRedirect('/guest');
        $response->assertStatus(302);
    }
}
