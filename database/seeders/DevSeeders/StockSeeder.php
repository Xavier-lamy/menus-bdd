<?php

namespace Database\Seeders\DevSeeders;

use Illuminate\Database\Seeder;
use App\Models\Command;
use App\Models\Stock;
use Carbon\Carbon;

class StockSeeder extends Seeder
{
    /**
     * Run the stock seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create some fake products in commands
        $ingredient_unit_array = array(
            ['flour', 'grams'],
            ['sugar', 'grams'],
            ['corn', 'grams'],
            ['raspberries', 'grams'],
            ['strawberries', 'grams'],
            ['milk', 'centiliters'],
            ['cream', 'centiliters'],
            ['orange juice', 'centiliters'],
            ['eggs', 'units'],
            ['carrots', 'units'],
            ['potatoes', 'units'],
            ['flour', 'bags(25kg)'],
            ['sugar', 'bags(10kg)'],
        );

        foreach($ingredient_unit_array as $product){
            $random_alert_stock = random_int(0, 60)*100;

            command::create([
                'ingredient' => $product[0],
                'quantity' => 0,
                'unit' => $product[1],
                'alert_stock' => $random_alert_stock,
                'must_buy' => 0,
            ]);
        }

        //Fetch the news products in command
        $commands = Command::all();

        //For each product in command create 2 fake products in stocks
        foreach($commands as $command){
            $random_quantity = random_int(1, 60)*100;
            $random_quantity2 = random_int(1, 60)*100;
            $random_date = Carbon::today()
                ->subDays(random_int(0, 50))
                ->adddays(random_int(0, 200))
                ->format('Y-m-d');
            $random_date2 = Carbon::today()
                ->subDays(random_int(0, 50))
                ->adddays(random_int(0, 200))
                ->format('Y-m-d');
            
                Stock::create([
                    'quantity' => $random_quantity,
                    'useby_date' => $random_date,
                    'command_id' => $command['id'],
                ]);

                Stock::create([
                    'quantity' => $random_quantity2,
                    'useby_date' => $random_date2,
                    'command_id' => $command['id'],
                ]);

                $alert_stock = $command->alert_stock;
                $command_quantity = $command->quantity;
                $stock_quantities = $random_quantity + $random_quantity2;
                $newquantity = $command_quantity + $stock_quantities;
                $must_buy = 0;
        
                if($newquantity <= $alert_stock){
                    $must_buy = 1;
                }
        
                $command->update([
                    'quantity' => $newquantity,
                    'must_buy' => $must_buy,
                ]);
        }
    }
}
