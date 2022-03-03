<?php

namespace Database\Seeders\DevSeeders;

use Illuminate\Database\Seeder;
use Database\Seeders\DatabaseSeeder;
use App\Models\Recipe;
use App\Models\Quantity;

class RecipeSeeder extends Seeder
{
        /**
     * Run the recipe seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipe_array = array(
            ['Tart', 'This is the correct method for a tart'],
            ['Cake', 'This is a method for a cake'],
            ['Pastas', 'This is just a method for pastas'],
            ['Sandwich', 'This is a recipe for a sandwich'],
            ['Cheese pie', 'This is just a method for a cheese pie'],
            ['Steer fried rice', 'This is a method for steer fried rice'],
            ['Omelet', 'This is a recipe for an omelet'],
        );

        $i = 1;

        foreach($recipe_array as $recipe){
            $random_quantities = array(
                random_int(1, 50)*10,
                random_int(1, 50)*10,
                random_int(1, 50)*10,
                random_int(1, 50)*10,
            );

            Recipe::create([
                'id' => $i,
                'name' => $recipe[0],
                'process' => $recipe[1],
                'user_id' => DatabaseSeeder::DEVENV_USER_ID,
            ]);

            $random_command_id = array(
                random_int(1, 12),
                random_int(1, 12),
                random_int(1, 12),
                random_int(1, 12),
            );

            Quantity::insert([
                ['quantity'=> $random_quantities[0], 'command_id'=> $random_command_id[0], 'recipe_id' => $i, 'user_id' => DatabaseSeeder::DEVENV_USER_ID,],
                ['quantity'=> $random_quantities[1], 'command_id'=> $random_command_id[1], 'recipe_id' => $i, 'user_id' => DatabaseSeeder::DEVENV_USER_ID,],
                ['quantity'=> $random_quantities[2], 'command_id'=> $random_command_id[2], 'recipe_id' => $i, 'user_id' => DatabaseSeeder::DEVENV_USER_ID,],
                ['quantity'=> $random_quantities[3], 'command_id'=> $random_command_id[3], 'recipe_id' => $i, 'user_id' => DatabaseSeeder::DEVENV_USER_ID,],
            ]);

            $i++;
        };
    }
}