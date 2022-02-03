<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Menu;

class MenuTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test if menu method "Store" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - A new menu is added in menu table
     * 
     * @test
     */
    public function storeInMenu()
    {
        $this->withoutExceptionHandling();

        //Send request for storing a menu
        $response = $this->post('/menu/add', [
            'day' => '2022-02-10',
            'morning' => array(
                array(
                    'recipe'=> 1,
                    'quantity'=> 360
                ),
                array(
                    'recipe'=> 2,
                    'quantity'=> 120
                )
            ),
            'noon' => array(
                array(
                    'recipe'=> 3,
                    'quantity'=> 200
                ),
                array(
                    'recipe'=> 4,
                    'quantity'=> 400
                )
            ),
            'evening' => array(
                array(
                    'recipe'=> 4,
                    'quantity'=> 650
                )
            ),
        ]);

        //Check if new menu is added in table:
        $menu = Menu::where([
            'id' => 1,
            'day' => '2022-02-10',
        ])->exists();

        $this->assertTrue($menu);

        //Test redirection with message
        $response
        ->assertRedirect('/menus')
        ->assertSessionHas([
            'success' => 'Menu added !',
        ]);
    }

    /**
     * Test if menu method Update work as intended:
     *  - Redirect
     *  - Return a success message
     *  - menu is correctly updated
     * 
     *  @test
     */
    public function updateMenu()
    {
        $this->withoutExceptionHandling();

        //Test redirection with message
/*         $response
        ->assertRedirect('/menu/show/1')
        ->assertSessionHas([
            'success' => 'Menu updated !',
        ]); */
    }

    /**
     * Test if menu method "Destroy" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - Return the correct amount of deleted entries
     *  - The menu is correctly delete from menus
     *  
     * @test
     */
    public function destroyMenu()
    {
        $this->withoutExceptionHandling();

    }
}
