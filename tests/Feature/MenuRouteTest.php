<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MenuRouteTest extends TestCase
{
    //View:
    /**
     * Test menus view
     * 
     * @test
     * @return void
     */
    public function menusView()
    {
        $response = $this->get('/menus');

        $response->assertViewIs('menus');
    }

    //Routes:
    /**
     * Test menus route 
     *
     * @test
     * @return void
     */
    public function menusIndexRoute()
    {
        $response = $this->get('/menus');

        $response->assertStatus(200);
    }

    /**
     * Test menu.show route 
     *
     * @test
     * @return void
     */
    public function menuShowRoute()
    {
        $response = $this->get('/menu/show/{id}');

        $response->assertStatus(302);
    }

    /**
     * Test menu.create route 
     *
     * @test
     * @return void
     */
    public function menusCreateRoute()
    {
        $response = $this->get('/menu/create');

        $response->assertStatus(200);
    }

    /**
     * Test menu.add route 
     *
     * @test
     * @return void
     */
    public function menusAddRoute()
    {
        $response = $this->post('/menu/add');

        $response->assertStatus(302);
    }

    /**
     * Test menu.modify route 
     *
     * @test
     * @return void
     */
    public function menusModifyRoute()
    {
        $response = $this->get('/menu/modify/{id}');

        $response->assertStatus(302);
    }

    /**
     * Test menu.apply route 
     *
     * @test
     * @return void
     */
    public function menusApplyRoute()
    {
        $response = $this->post('/menu/apply/{id}');

        $response->assertStatus(302);
    }

    /**
     * Test menu-delete-confirmation route 
     *
     * @test
     * @return void
     */
    public function menusDeleteConfirmRoute()
    {
        $response = $this->post('/menu-delete-confirmation');

        $response->assertStatus(302);
    }

    /**
     * Test menu.delete route 
     *
     * @test
     * @return void
     */
    public function menusDeleteRoute()
    {
        $response = $this->post('/menus/delete');

        $response->assertStatus(200);
    }
}
