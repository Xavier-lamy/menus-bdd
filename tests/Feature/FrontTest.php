<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TestSeeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class FrontTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test front view
     * 
     * @test
     * @return void
     */
    public function FrontRouteReturnFrontViewIfAuth()
    {
        $this->seed(TestDatabaseSeeder::class);

        $user = User::find(TestDatabaseSeeder::TESTENV_USER_ID);

        $response = $this->actingAs($user)->get('/');

        $response->assertViewIs('front')->assertStatus(200);
    }

    /**
     * Test only authenticated user can access to front view
     * 
     * @test
     * @return void
     */
    public function FrontRouteRedirectToGuestIfNotAuth()
    {
        $response = $this->get('/');

        $response->assertRedirect('/guest');
        $response->assertStatus(302);
    }
}
