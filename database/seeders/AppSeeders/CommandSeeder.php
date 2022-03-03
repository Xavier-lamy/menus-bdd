<?php

namespace Database\Seeders\AppSeeders;

use Illuminate\Database\Seeder;
use App\Models\Command;

class CommandSeeder extends Seeder
{
    /**
     * Create basics ingredients for the app (this seeder is not used by artisan,
     * and can only be called statically by a function)
     *
     * @return void
     */
    public static function seedApp($userId)
    {
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
        );

        foreach($ingredient_unit_array as $product){
            command::create([
                'ingredient' => $product[0],
                'quantity' => 0,
                'unit' => $product[1],
                'alert_stock' => 0,
                'must_buy' => 0,
                'user_id' => $userId,
            ]);
        }
    }
}
