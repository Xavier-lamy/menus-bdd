<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\TestSeeders\TestDatabaseSeeder;
use Tests\TestCase;
use App\Models\Command;
use App\Models\Quantity;
use App\Models\Recipe;
use App\Models\User;

class RecipeTest extends TestCase
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
     * Test only authenticated user can access to recipes view
     * 
     * @test
     * @return void
     */
    public function recipesRouteRedirectToGuestIfNotAuth()
    {
        $response = $this->get('/recipes');

        $response->assertRedirect('/guest');
        $response->assertStatus(302);
    }

    /**
     * Test recipes index method and view
     * 
     * @test
     * @return void
     */
    public function recipeIndexIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/recipes');

        $response->assertViewIs('recipes')->assertStatus(200);
    }

    /**
     * Test recipe create method and view 
     *
     * @test
     * @return void
     */
    public function recipeCreateIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/recipe/create');

        $response
            ->assertViewIs('recipe')
            ->assertViewHas('is_creating')
            ->assertViewHas('commands_products')
            ->assertStatus(200);
    }

    /**
     * Test if Recipe method "Store" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - A new recipe is added (with a title, a method and a total) in recipe table
     *  - New recipe ingredients had been added to quantity table with the correct id
     * 
     * @test
     * @return void
     */
    public function recipeStoreIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/recipe/add', [
            'recipe_name' => 'new_recipe',
            'ingredient' => array(
                array(
                    'command_id'=> 1,
                    'quantity'=> 10
                ),
                array(
                    'command_id'=> 2,
                    'quantity'=> 10
                )
            ),
            'process' => 'new_process',
        ]);

        //Check if recipe is added to recipe table
        $recipe = Recipe::where([
            'id' => 3, //Because there is already 2 recipes
            'name' => 'new_recipe',
            'process' => 'new_process',
            'total' => null, //Because two units are different
            'user_id' => $this->user->id,
        ])->exists();

        $this->assertTrue($recipe);

        //Check if two entries are found with recipe_id = 1 in quantities
        $quantities = Quantity::where([
            'recipe_id' => 1,
            'user_id' => $this->user->id,
        ])->get();
        
        $this->assertEquals(2, count($quantities));

        //Test redirection with message
        $response
        ->assertRedirect('/recipes')
        ->assertSessionHas([
            'success' => 'Recipe created !',
        ]);
    }

    /**
     * Test recipe show method and view 
     *
     * @test
     * @return void
     */
    public function recipeShowIfAuth()
    {
        $response = $this->actingAs($this->user)->get('/recipe/show/1');

        $response
            ->assertViewIs('recipe')
            ->assertViewHas('recipe')
            ->assertViewHas('quantities')
            ->assertStatus(200);
    }

    /**
     * Test recipe edit method and view 
     *
     * @test
     * @return void
     */
    public function recipeEditIfAuth()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->user)->get('/recipe/modify/1');

        $response
            ->assertViewIs('recipe')
            ->assertViewHas('recipe')
            ->assertViewHas('is_editing')
            ->assertViewHas('commands_products')
            ->assertStatus(200);
    }

    /**
     * Test if recipe method Update work as intended:
     *  - Redirect
     *  - Return a success message
     *  - Recipe is correctly updated
     *  - Quantities for this recipe are correctly updated
     * 
     *  @test
     *  @return void
     */
    public function recipeUpdateIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/recipe/apply', [
            'id' => 1,
            'recipe_name' => 'new_recipe_name',
            'ingredient' => array(
                array(
                    'command_id'=> 1,
                    'quantity'=> 10,
                )
            ),
            'process' => 'new_process',
        ]);

        //Check if recipe is correctly updated
        $recipe = Recipe::where([
            'id' => 1,
            'name' => 'new_recipe_name',
            'process' => 'new_process',
            'total' => 10, //Because there is only one ingredient unit now
            'user_id' => $this->user->id,
        ])->exists();

        $this->assertTrue($recipe);

        //Check if ingredient list has been updated
        $ingredients = Quantity::where([
            'recipe_id' => 1,
            'user_id' => $this->user->id,
        ])->get();

        $this->assertEquals(1, count($ingredients));

        //Test redirection with message
        $response
        ->assertRedirect('/recipe/show/1')
        ->assertSessionHas([
            'success' => 'Recipe updated !',
        ]);
    }

    /**
     * Test recipe delete-confirmation method and view 
     *
     * @test
     * @return void
     */
    public function recipeDeleteConfirmIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/recipe-delete-confirmation');

        //Should return an error message and redirect to recipes, because no products are selected
        $response
            ->assertRedirect('/recipes')
            ->assertSessionHas('message', 'You need to select recipes first !')
            ->assertStatus(302);
    }

    /**
     * Test if Recipe method "Destroy" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - Return the correct amount of deleted entries
     *  - The recipe is correctly delete from recipes
     *  - No related ingredients are found in quantities table
     *  
     * @test
     */
    public function recipeDestroyIfAuth()
    {
        $response = $this->actingAs($this->user)->post('/recipes/delete', [
            'delete_1' => 1,
        ]);

        //Check if the products we delete are not there anymore
        $recipe = Recipe::find(1);
        
        $this->assertTrue(empty($recipe));

        //Check if ingredients related to this recipe were deleted correctly
        $quantities = Quantity::where([
            'recipe_id' => 1,
        ])->exists();

        $this->assertFalse($quantities);

        $response
            ->assertStatus(200)
            ->assertSessionHas([
                'success' => '1 entry deleted !',
            ]);
    }
}
