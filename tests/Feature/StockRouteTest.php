<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockRouteTest extends TestCase
{
    //View:
    /**
     * Test stocks view
     *
     * @return void
     */
    public function testStocksView()
    {
        $response = $this->get('/stocks');

        $response->assertViewIs('stocks');
    }

    //Routes:
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
    public function testStocksCreateRoute()
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

        $response->assertStatus(200);
    }
}
