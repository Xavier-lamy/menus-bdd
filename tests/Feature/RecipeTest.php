<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Command;
use App\Models\Quantity;
use App\Models\Recipe;

class RecipeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test if Recipe method "Store" work as intended:
     *  - Redirect
     *  - Return a success message
     *  - A new recipe is added (with a title, a method and a total) in recipe table
     *  - New recipe ingredients had been added to quantity table with the correct id
     * 
     * @test
     */
    public function storeInRecipe()
    {
        $this->withoutExceptionHandling();

        //Create fakes products in command
        Command::create([
            'id' => 1,
            'ingredient' => 'sugar',
            'quantity' => 0,
            'unit' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 1,
        ]);

        Command::create([
            'id' => 2,
            'ingredient' => 'milk',
            'quantity' => 0,
            'unit' => 'grams',
            'alert_stock' => 200,
            'must_buy' => 1,
        ]);

        //Test storing request
        $response = $this->post('/recipe/add', [
            'recipe_name' => 'Tart',
            'ingredient' => array(
                array(
                    'command_id'=> 1,
                    'quantity'=> 200
                ),
                array(
                    'command_id'=> 2,
                    'quantity'=> 400
                )
            ),
            'process' => 'Do something nice',
        ]);

        //Check if recipe is added to recipe table
        $recipe = Recipe::where([
            'id' => 1,
            'name' => 'Tart',
            'process' => 'Do something nice',
            'total_weight' => 600
        ])->exists();

        $this->assertTrue($recipe);

        //Check if two entries are found with recipe_id = 1
        $quantities = Quantity::where([
            'recipe_id' => 1,
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
     * Test if recipe method Update work as intended:
     *  - Redirect
     *  - Return a success message
     *  - Recipe is correctly updated
     *  - Quantities for this recipe are correctly updated
     * 
     *  @test
     */
    public function updateRecipe()
    {
        $this->withoutExceptionHandling();

        //Create a fake recipe
        Recipe::create([
            'id' => 1,
            'name' => 'Tart',
            'process' => 'This is the process',
            'total_weight' => 600,
        ]);

        //Create ingredient names in database
        Command::create([
            'id' => 1,
            'ingredient' => 'sugar',
            'quantity' => 0,
            'unit' => 'grams',
            'alert_stock' => 150,
            'must_buy' => 1,
        ]);

        Command::create([
            'id' => 2,
            'ingredient' => 'milk',
            'quantity' => 0,
            'unit' => 'grams',
            'alert_stock' => 200,
            'must_buy' => 1,
        ]);

        Quantity::create([
            'quantity'=> 300,
            'command_id'=> 1,
            'recipe_id' => 1,
        ]);

        Quantity::create([
            'quantity'=> 300,
            'command_id'=> 2,
            'recipe_id' => 1,
        ]);

        $response = $this->post('/recipe/apply', [
            'id' => 1,
            'recipe_name' => 'Tart',
            'ingredient' => array(
                array(
                    'command_id'=> 1,
                    'quantity'=> 200
                )
            ),
            'process' => 'This is the new process',
        ]);

        //Check if recipe is correctly updated
        $recipe = Recipe::where([
            'id' => 1,
            'name' => 'Tart',
            'process' => 'This is the new process',
            'total_weight' => 200,
        ])->exists();

        $this->assertTrue($recipe);

        //Check if ingredient list has been updated
        $ingredients = Quantity::where([
            'recipe_id' => 1,
        ])->get();

        $this->assertEquals(1, count($ingredients));

        //Test redirection with message
        $response
        ->assertRedirect('/recipe')
        ->assertSessionHas([
            'success' => 'Recipe updated !',
        ]);
    }
}
