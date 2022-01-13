<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * Test front view
     *
     * @return void
     */
    public function testFrontView()
    {
        $response = $this->get('/');

        $response->assertViewIs('front');
    }

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

    /**
     * Test commands view
     *
     * @return void
     */
    public function testCommandsView()
    {
        $response = $this->get('/total-stocks');

        $response->assertViewIs('total-stocks');
    }
}
