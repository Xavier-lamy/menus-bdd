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
                random_int(1, 7),
                random_int(1, 7),
                random_int(1, 7),
                random_int(1, 7),
                random_int(1, 7),
            );
            $random_portions = array(
                random_int(1, 5),
                random_int(1, 5),
                random_int(1, 5),
                random_int(1, 5),
                random_int(1, 5),
            );

            Menu::create([
                "day" => $date[$i],
                "morning" => [$random_ids[0] => $random_portions[1], $random_ids[3] => $random_portions[0]],
                "noon" => [$random_ids[2] => $random_portions[3], $random_ids[1] => $random_portions[3]],
                "evening" => [$random_ids[4] => $random_portions[4], $random_ids[2] => $random_portions[2]],
            ]);
        }
    }
}