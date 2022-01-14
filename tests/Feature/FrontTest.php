<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FrontTest extends TestCase
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
     * Test front route 
     *
     * @return void
     */
    public function testFrontRoute()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
