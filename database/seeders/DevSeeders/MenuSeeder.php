<?php

namespace Database\Seeders\DevSeeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Dish;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    /**
     * Run the menu seeds.
     *
     * @return void
     */
    public function run()
    {
        //Generate 5 dates starting from today
        for($date_increment = 0; $date_increment <= 4; $date_increment++){
            $date[] = Carbon::today()
            ->adddays($date_increment)
            ->format('Y-m-d');                
        }

        for($i = 0; $i <= 4; $i++){
            Menu::create([
                'day' => $date[$i],
            ]);
        }

        //Generate three entries per menu in dishes
        for($i = 1; $i <= 5; $i++){
            foreach(Dish::MOMENTS as $moment => $value) {
                Dish::create([
                    'menu_id' => $i,
                    'moment' => $moment,
                    'recipe_id' => random_int(1, 7),
                    'portion' => random_int(1, 6),
                ]);
            }
        }
    }
}