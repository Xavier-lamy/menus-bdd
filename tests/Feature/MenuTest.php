<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TestSeeders\TestDatabaseSeeder;
use Tests\TestCase;
use App\Models\Menu;
use App\Models\Dish;
use App\Models\User;

class MenuTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Prepare the database for tests with the test seeders
     */
    public function setUp(): void
    {
        parent::setUp();
        
        $this->seed(TestDatabaseSeeder::class);

        $this->user = User::find(TestDatabaseSeeder::TESTENV_USER_ID);

    }

    /**
     * Test only authenticated user can access to menus view
     * 
     * @test
     * @return void
     */
    public function menusRouteRedirectToGuestIfNotAuth()
    {
        $response = $this->get('/menus');

        $response->assertRedirect('/guest');
        $response->assertStatus(302);
    }

    /**
     * Test menus index method and view
     * 
     * @test
     * @return void
     */
    public function menuIndexIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/menus');

        $response->assertViewIs('menus')->assertStatus(200);
    }

    /**
     * Test menu create method and view 
     *
     * @test
     * @return void
     */
    public function menuCreateIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/menu/create');

        $response
            ->assertViewIs('menu')
            ->assertViewHas('is_creating')
            ->assertViewHas('recipes')
            ->assertViewHas('moments')
            ->assertStatus(200);
    }

    /**
     * Test if menu method "Store" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - A new menu is added in menu table
     * 
     * @test
     * @return void
     */
    public function menuStoreIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/menu/add', [
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

        //Check if new menu is added in table: 
        $menu = Menu::where([
            'id' => 2, //because there is 1 menu in test database
            'day' => '2021-12-30',
            'user_id' => $this->user->id,
        ])->exists();

        $this->assertTrue($menu);

        //Check if recipes and portions have been added
        
        //check dishes
        $dish1 = Dish::where([
            'menu_id' => 2,
            'moment' => 'morning',
            'recipe_id' => 1,
            'portion' => 5,
            'user_id' => $this->user->id,
        ])->first();

        $dish2 = Dish::where([
            'menu_id' => 2,
            'moment' => 'noon',
            'recipe_id' => 2,
            'portion' => 5,
            'user_id' => $this->user->id,
        ])->first();

        //There shouldn't be any dish with moment = evening for this menu
        $dish3 = Dish::where([
            'menu_id' => 2,
            'moment' => 'evening',
            'user_id' => $this->user->id,
        ])->first(); 

        $this->assertNotEmpty($dish1);
        $this->assertNotEmpty($dish2);
        $this->assertEmpty($dish3);

        //check if number of added dishes is like expected
        $dishes = Dish::where([
            'menu_id' => 2,
        ])->get();

        $expected_count = 2; //Expect to have two entries

        $this->assertCount($expected_count, $dishes);

        //Test redirection with message
        $response
        ->assertRedirect('/menus')
        ->assertSessionHas([
            'success' => 'Menu added !',
        ]);
    }

    /**
     * Test menu show method and view 
     *
     * @test
     * @return void
     */
    public function menuShowIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/menu/show/1');

        $response
            ->assertViewIs('menu')
            ->assertViewHas('menu')
            ->assertViewHas('moments')
            ->assertStatus(200);
    }

    /**
     * Test menu edit method and view 
     *
     * @test
     * @return void
     */
    public function menuEditIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/menu/modify/1');

        $response
            ->assertViewIs('menu')
            ->assertViewHas('is_editing')
            ->assertViewHas('menu')
            ->assertViewHas('moments')
            ->assertViewHas('recipes')
            ->assertStatus(200);
    }

    /**
     * Test if menu method Update work as expected:
     *  - Redirect
     *  - Return a success message
     *  - menu is correctly updated
     * 
     *  @test
     *  @return void
     */
    public function menuUpdateIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/menu/apply/1', [
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
            'menu_id' => 1,
            'moment' => 'evening',
            'user_id' => $this->user->id,
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
     * Test menu delete-confirmation method and view 
     *
     * @test
     * @return void
     */
    public function menuDeleteConfirmIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/menu-delete-confirmation');

        //Should return an error message and redirect to menus, because no menu is selected
        $response
            ->assertRedirect('/menus')
            ->assertSessionHas('message', 'You need to select menus first !')
            ->assertStatus(302);
    }

    /**
     * Test if menu method "Destroy" work as expected:
     *  - Redirect
     *  - Return a success message with the correct amount of deleted entries
     *  - The menu is correctly delete from menus
     *  
     * @test
     * @return void
     */
    public function menuDestroyIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/menus/delete', [
            'delete_1' => 1,
        ]);

        //Check if the deleted product is not there anymore
        $menu = Menu::find(1);
        
        $this->assertEmpty($menu);

        $response
            ->assertStatus(200)
            ->assertSessionHas([
                'success' => '1 entry deleted !',
            ]);

    }
}
