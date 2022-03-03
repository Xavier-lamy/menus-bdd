<?php

namespace Database\Seeders\TestSeeders;

use Illuminate\Database\Seeder;
use App\Models\Command;
use App\Models\Stock;

class TestStockSeeder extends Seeder
{
    /**
     * Run the stock seeds.
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

        //Create 2 fake products in commands
        $ingredient_unit_array = array(
            ['test-ingredient-1', 'test-unit-1'],
            ['test-ingredient-2', 'test-unit-2'],
        );

        foreach($ingredient_unit_array as $product){

            command::create([
                'ingredient' => $product[0],
                'quantity' => 0,
                'unit' => $product[1],
                'alert_stock' => 10,
                'must_buy' => 0,
                'user_id' => TestDatabaseSeeder::TESTENV_USER_ID,
            ]);

        }

        //Fetch the news products in command
        $commands = Command::all();

        //For each product in command create 2 fake products in stocks (for a total of 4 products)
        foreach($commands as $command){
                Stock::create([
                    'quantity' => 10,
                    'useby_date' => '2020-01-01',
                    'command_id' => $command['id'],
                    'user_id' => TestDatabaseSeeder::TESTENV_USER_ID,
                ]);

                Stock::create([
                    'quantity' => 10,
                    'useby_date' => '2020-01-02',
                    'command_id' => $command['id'],
                    'user_id' => TestDatabaseSeeder::TESTENV_USER_ID,
                ]);

                $alert_stock = $command->alert_stock;
                $command_quantity = $command->quantity;
                $stock_quantities = 20;
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
