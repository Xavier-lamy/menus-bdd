<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipeRouteTest extends TestCase
{
    //View:
    /**
     * Test recipes view
     * 
     * @return void
     */
    public function testRecipesView()
    {
        $response = $this->get('/recipes');

        $response->assertViewIs('recipes');
    }

    //Routes:
    /**
     * Test recipes route 
     *
     * @return void
     */
    public function testRecipesRoute()
    {
        $response = $this->get('/recipes');

        $response->assertStatus(200);
    }

    /**
     * Test recipe.show route 
     *
     * @return void
     */
    public function testRecipeShowRoute()
    {
        $response = $this->get('/recipe/{$id}');

        $response->assertStatus(200);
    }

    /**
     * Test recipe.create route 
     *
     * @return void
     */
    public function testRecipesCreateRoute()
    {
        $response = $this->get('/recipe/create');

        $response->assertStatus(200);
    }

    /**
     * Test recipe.add route 
     *
     * @return void
     */
    public function testRecipesAddRoute()
    {
        $response = $this->post('/recipe/create');

        $response->assertStatus(302);
    }

    /**
     * Test recipe.modify route 
     *
     * @return void
     */
    public function testRecipesModifyRoute()
    {
        $response = $this->get('/recipe/modify/{id}');

        $response->assertStatus(200);
    }

    /**
     * Test recipe.apply route 
     *
     * @return void
     */
    public function testRecipesApplyRoute()
    {
        $response = $this->post('/recipe/modify');

        $response->assertStatus(302);
    }

    /**
     * Test recipe-delete-confirmation route 
     *
     * @return void
     */
    public function testRecipesDeleteConfirmRoute()
    {
        $response = $this->post('/recipe-delete-confirmation');

        $response->assertStatus(302);
    }

    /**
     * Test recipe.delete route 
     *
     * @return void
     */
    public function testRecipesDeleteRoute()
    {
        $response = $this->post('/recipes/delete');

        $response->assertStatus(302);
    }
}
