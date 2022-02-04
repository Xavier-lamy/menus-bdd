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
                    'portion'=> 2
                ),
                array(
                    'recipe'=> 2,
                    'portion'=> 2
                )
            ),
            'noon' => array(
                array(
                    'recipe'=> 3,
                    'portion'=> 3
                ),
                array(
                    'recipe'=> 4,
                    'portion'=> 3
                )
            ),
            'evening' => array(
                array(
                    'recipe'=> 4,
                    'portion'=> 4
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
     *  - Return a success message with the correct amount of deleted entries
     *  - The menu is correctly delete from menus
     *  
     * @test
     */
    public function destroyMenu()
    {
        $this->withoutExceptionHandling();

        //Create two fake menus in bdd
        Menu::create([
            'id' => 1,
            'day' => "2020-02-04",
            'morning' => [1 => 2, 3 => 1],
            'noon' => [4 => 6, 1 => 6],
            'evening' => [5 => 4, 2 => 4],
        ]);

        Menu::create([
            'id' => 2,
            'day' => "2020-02-05",
            'morning' => [3 => 1],
            'noon' => [4 => 6, 1 => 2, 5 => 4,],
            'evening' => [5 => 4, 2 => 4],
        ]);


        $response = $this->post('/menus/delete', [
            'delete_1' => 1,
            'delete_2' => 2,
        ]);

        //Check if the products we delete are not there anymore
        $menu1 = Menu::find(1);
        $menu2 = Menu::find(2);
        
        $this->assertTrue(empty($menu1));
        $this->assertTrue(empty($menu2));

        $response
            ->assertRedirect('/menus')
            ->assertSessionHas([
                'success' => '2 entries deleted !',
            ]);

    }
}
