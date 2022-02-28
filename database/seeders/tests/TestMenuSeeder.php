<?php

namespace Database\Seeders\Tests;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Dish;

class TestMenuSeeder extends Seeder
{
    /**
     * Run the menu seeds.
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

        //Create 1 menu with one dish for morning, and one for noon, none for evening
        Menu::create([
            'day' => '2020-01-01',
        ]);

        Dish::create([
            'menu_id' => 1,
            'meal_time' => Dish::MEAL_TIME[0],
            'recipe_id' => 1,
            'portion' => 10,
        ]);

        Dish::create([
            'menu_id' => 1,
            'meal_time' => Dish::MEAL_TIME[1],
            'recipe_id' => 2,
            'portion' => 10,
        ]);

    }
}