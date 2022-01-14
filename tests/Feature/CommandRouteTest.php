<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandRouteTest extends TestCase
{ 
    //View:
    /**
     * Test commands view
     *
     * @return void
     */
    public function testCommandsView()
    {
        $response = $this->get('/commands');

        $response->assertViewIs('commands');
    }

    //Routes:
    /**
     * Test command route 
     *
     * @return void
     */
    public function testCommandsRoute()
    {
        $response = $this->get('/commands');

        $response->assertStatus(200);
    }

    /**
     * Test command.create route 
     *
     * @return void
     */
    public function testCommandsCreateRoute()
    {
        $response = $this->get('/commands/create');

        $response->assertStatus(200);
    }

    /**
     * Test command.add route 
     *
     * @return void
     */
    public function testCommandsAddRoute()
    {
        $response = $this->post('/commands/create');

        $response->assertStatus(302);
    }

    /**
     * Test command.modify route 
     *
     * @return void
     */
    public function testCommandsModifyRoute()
    {
        $response = $this->get('/commands/modify/{id}');

        $response->assertStatus(200);
    }

    /**
     * Test command.apply route 
     *
     * @return void
     */
    public function testCommandsApplyRoute()
    {
        $response = $this->post('/commands/modify');

        $response->assertStatus(302);
    }

    /**
     * Test command-delete-confirmation route 
     *
     * @return void
     */
    public function testCommandsDeleteConfirmRoute()
    {
        $response = $this->post('/command-delete-confirmation');

        $response->assertStatus(302);
    }

    /**
     * Test command.delete route 
     *
     * @return void
     */
    public function testCommandsDeleteRoute()
    {
        $response = $this->post('/commands/delete');

        $response->assertStatus(302);
    }
}
