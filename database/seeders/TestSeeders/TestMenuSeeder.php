<?php

namespace Database\Seeders\TestSeeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Dish;

class TestMenuSeeder extends Seeder
{
    /**
     * Run the menu seeds.
     * 
     * In order to make tests easier:
     *  - all texts should have "new" inside so this will be sure there is no occurence of this already in test database
     *  - all number are 10 and should be changed to 5 during tests
     *  - all dates are 2020-01-01 (and 2020-01-02 if another one is needed)
     *    and should be changed to 2021-12-30 and 2021-12-31  during tests
     *
     * @return void
     */
    public function run()
    {
        //Create 1 menu with one dish for morning, and one for noon, none for evening
        Menu::create([
            'day' => '2020-01-01',
            'user_id' => TestDatabaseSeeder::TESTENV_USER_ID,
        ]);

        Dish::create([
            'menu_id' => 1,
            'moment' => 'morning',
            'recipe_id' => 1,
            'portion' => 10,
            'user_id' => TestDatabaseSeeder::TESTENV_USER_ID,
        ]);

        Dish::create([
            'menu_id' => 1,
            'moment' => 'noon',
            'recipe_id' => 2,
            'portion' => 10,
            'user_id' => TestDatabaseSeeder::TESTENV_USER_ID,
        ]);

    }
}