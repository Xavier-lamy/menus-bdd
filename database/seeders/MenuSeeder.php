<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
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
            $random_ids = array(
                random_int(1, 12),
                random_int(1, 12),
                random_int(1, 12),
                random_int(1, 12),
                random_int(1, 12),
            );
            $random_quantities = array(
                random_int(1, 20)*100,
                random_int(1, 20)*100,
                random_int(1, 20)*100,
                random_int(1, 20)*100,
                random_int(1, 20)*100,
            );

            Menu::create([
                "day" => $date[$i],
                "morning" => [$random_ids[0] => $random_quantities[1], $random_ids[3] => $random_quantities[0]],
                "noon" => [$random_ids[2] => $random_quantities[3], $random_ids[1] => $random_quantities[3]],
                "evening" => [$random_ids[4] => $random_quantities[4], $random_ids[2] => $random_quantities[2]],
            ]);
        }
    }
}