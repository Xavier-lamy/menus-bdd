<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Menu;
use App\Models\Dish;
use Database\Seeders\TestSeeders\TestDatabaseSeeder;

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

        //Run seeders for menus and recipes
        $this->seed(TestDatabaseSeeder::class);

        //Send request for storing a menu
        $response = $this->post('/menu/add', [
            'day' => '2021-12-30',
            'morning' => array(
                array(
                    'recipe'=> 1,
                    'portion'=> 5
                )
            ),
            'noon' => array(
                array(
                    'recipe'=> 2,
                    'portion'=> 5
                )
            ),
            'evening' => array(),
        ]);

        //Check if new menu is added in table: there is 1 menu in test database so new id should be 2
        $menu = Menu::where([
            'id' => 2,
            'day' => '2021-12-30',
        ])->exists();

        $this->assertTrue($menu);

        //Check if recipes and portions have been added
        
        //check one dish
        $this->assertDatabaseHas('dishes', [
            'menu_id' => 2,
            'moment' => 'morning',
            'recipe_id' => 1,
            'portion' => 5
        ]);

        //check if number of added dishes is like expected
        $dishes = Dish::where([
            'menu_id' => 2,
        ])->get();

        //Expect to have two entries
        $expected_count = 2;

        $this->assertCount($expected_count, $dishes);

        //Test redirection with message
        $response
        ->assertRedirect('/menus')
        ->assertSessionHas([
            'success' => 'Menu added !',
        ]);
    }

    /**
     * Test if menu method Update work as expected:
     *  - Redirect
     *  - Return a success message
     *  - menu is correctly updated
     * 
     *  @test
     */
    public function updateMenu()
    {
        $this->withoutExceptionHandling();

        //Run testing seeders
        $this->seed(TestDatabaseSeeder::class);

        //Send request for updating menu date and evening dishes for test menu 1
        $response = $this->post('/menu/apply/1', [
            'day' => '2021-12-30',
            'morning' => array(
                array(
                    'recipe'=> 1,
                    'portion'=> 10,
                    'id'=> 1
                )
            ),
            'noon' => array(
                array(
                    'recipe'=> 2,
                    'portion'=> 10,
                    'id'=> 1
                )
            ),
            'evening' => array(
                array(
                    'recipe'=> 2,
                    'portion'=> 5
                )
            ),
        ]);

        //Check if menu is updated (date has changed):
        $menu = Menu::where([
            'id' => 1,
            'day' => '2021-12-30',
        ])->first();
        
        $this->assertNotEmpty($menu);

        //Check if dish is updated (evening should have only one with recipe_id = 2, portion = 5)
        $dishes = Dish::where([
            'moment' => 'evening'
        ])->get();

        $this->assertCount(1, $dishes);

        $dish = $dishes->first();

        $expected_recipe = 2;
        $expected_portion = 5;

        $this->assertEquals($expected_recipe, $dish->recipe_id);
        $this->assertEquals($expected_portion, $dish->portion);

        //Test redirection with message
        $response
        ->assertRedirect('/menu/show/1')
        ->assertSessionHas([
            'success' => 'Menu updated !',
        ]);
    }

    /**
     * Test if menu method "Destroy" work as expected:
     *  - Redirect
     *  - Return a success message with the correct amount of deleted entries
     *  - The menu is correctly delete from menus
     *  
     * @test
     */
    public function destroyMenu()
    {
        $this->withoutExceptionHandling();

        //Run seeders for menus and recipes
        $this->seed(TestDatabaseSeeder::class);

        //Create a fake menu
        $response = $this->post('/menus/delete', [
            'delete_1' => 1,
        ]);

        //Check if the deleted product is not there anymore
        $menu1 = Menu::find(1);
        
        $this->assertTrue(empty($menu1));

        $response
            ->assertStatus(200)
            ->assertSessionHas([
                'success' => '1 entry deleted !',
            ]);

    }
}
