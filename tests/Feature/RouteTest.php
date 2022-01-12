<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * Test front route 
     *
     * @return void
     */
    public function testFrontRoute()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test stock route 
     *
     * @return void
     */
    public function testStocksRoute()
    {
        $response = $this->get('/stocks');

        $response->assertStatus(200);
    }

    /**
     * Test stock.create route 
     *
     * @return void
     */
    public function testStockscreateRoute()
    {
        $response = $this->get('/stocks/create');

        $response->assertStatus(200);
    }

    /**
     * Test stock.add route 
     *
     * @return void
     */
    public function testStocksAddRoute()
    {
        $response = $this->post('/stocks/create');

        $response->assertStatus(302);
    }

    /**
     * Test stock.modify route 
     *
     * @return void
     */
    public function testStocksModifyRoute()
    {
        $response = $this->get('/stocks/modify/{id}');

        $response->assertStatus(200);
    }

    /**
     * Test stock.apply route 
     *
     * @return void
     */
    public function testStocksApplyRoute()
    {
        $response = $this->post('/stocks/modify');

        $response->assertStatus(302);
    }

    /**
     * Test stock-delete-confirmation route 
     *
     * @return void
     */
    public function testStocksDeleteConfirmRoute()
    {
        $response = $this->post('/stock-delete-confirmation');

        $response->assertStatus(302);
    }

    /**
     * Test stock.delete route 
     *
     * @return void
     */
    public function testStocksDeleteRoute()
    {
        $response = $this->post('/stocks/delete');

        $response->assertStatus(302);
    }

    /**
     * Test command route 
     *
     * @return void
     */
    public function testCommandsRoute()
    {
        $response = $this->get('/total-stocks');

        $response->assertStatus(200);
    }

    /**
     * Test command.create route 
     *
     * @return void
     */
    public function testCommandscreateRoute()
    {
        $response = $this->get('/total-stocks/create');

        $response->assertStatus(200);
    }

    /**
     * Test command.add route 
     *
     * @return void
     */
    public function testCommandsAddRoute()
    {
        $response = $this->post('/total-stocks/create');

        $response->assertStatus(302);
    }

    /**
     * Test command.modify route 
     *
     * @return void
     */
    public function testCommandsModifyRoute()
    {
        $response = $this->get('/total-stocks/modify/{id}');

        $response->assertStatus(200);
    }

    /**
     * Test command.apply route 
     *
     * @return void
     */
    public function testCommandsApplyRoute()
    {
        $response = $this->post('/total-stocks/modify');

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
        $response = $this->post('/total-stocks/delete');

        $response->assertStatus(302);
    }

}
