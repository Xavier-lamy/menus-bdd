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
     * Prepare the database for tests with the test seeders
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TestDatabaseSeeder::class);

        $this->user = User::find(TestDatabaseSeeder::TESTENV_USER_ID);
    }

    /**
     * Test front view
     * 
     * @test
     * @return void
     */
    public function frontRouteReturnFrontViewIfAuth()
    {
/*         $this->seed(TestDatabaseSeeder::class);

        $user = User::find(TestDatabaseSeeder::TESTENV_USER_ID); */

        $response = $this->actingAs($this->user)->get('/');

        $response
            ->assertViewIs('front')
            ->assertStatus(200);
    }

    /**
     * Test only authenticated user can access to front view
     * 
     * @test
     * @return void
     */
    public function frontRouteRedirectToGuestIfNotAuth()
    {
        $response = $this->get('/');

        $response
            ->assertRedirect('/guest')
            ->assertStatus(302);
    }
}
