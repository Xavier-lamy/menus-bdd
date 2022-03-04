<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TestSeeders\TestDatabaseSeeder;
use Tests\TestCase;
use App\Models\User;
use App\Models\Option;

class OptionTest extends TestCase
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
     * Test only authenticated user can access to options view
     *
     * @test
     * @return void
     */
    public function optionsRouteRedirectToGuestIfNotAuth()
    {
        $response = $this->get('/options');

        $response->assertRedirect('/guest');
        $response->assertStatus(302);
    }

    /**
     * Test options index method and view
     *
     * @test
     * @return void
     */
    public function optionIndexIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/options');

        $response
            ->assertViewIs('options')
            ->assertViewHas('dish_moments')
            ->assertViewHas('command_created')
            ->assertViewHas('command_is_empty')
            ->assertStatus(200);
    }

}