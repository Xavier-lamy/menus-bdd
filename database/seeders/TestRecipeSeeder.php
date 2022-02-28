<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Quantity;

class TestRecipeSeeder extends Seeder
{
        /**
     * Run the recipe seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * In order to make tests easier:
         *  - all number are 10 and should be changed to 5 during tests
         *  - all dates are 2020-01-01 (and 2020-01-02 if another one is needed)
         *      and should be changed to 2021-12-30 and 2021-12-31  during tests
         */

        //Create 2 test recipes
        $recipe_array = array(
            ['Test Recipe 1', 'Test method 1'],
            ['Test Recipe 2', 'Test method 2'],
        );

        $i = 1;

        foreach($recipe_array as $recipe){
            Recipe::create([
                'id' => $i,
                'name' => $recipe[0],
                'process' => $recipe[1],
            ]);

            //Insert first command ingredient for 1st recipe and 2nd for 2nd recipe
            Quantity::insert([
                ['quantity'=> 10, 'command_id'=> 1, 'recipe_id' => $i,],
                ['quantity'=> 10, 'command_id'=> 2, 'recipe_id' => $i,],
            ]);

            $i++;
        };
    }
}