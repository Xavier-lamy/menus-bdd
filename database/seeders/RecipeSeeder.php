<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Command;
use App\Models\Recipe;
use App\Models\Quantity;
use Carbon\Carbon;

class RecipeSeeder extends Seeder
{
        /**
     * Run the recipe seeds.
     *
     * @return void
     */
    public function run()
    {
        Recipe::create([
            'id' => 1,
            'name' => 'Raspberry Cake',
            'process' => "Lorem ipsum dolor sit amet. 
            At alias deleniti et architecto atque non quasi Quis sit molestias eaque. 
            Et repellendus accusantium rem dolorem veritatis eos impedit voluptas cum ducimus odit quo vitae eius. 
            Ut ipsam autem vel beatae tempore sit eaque natus aut molestiae voluptates vel dicta possimus.
            Est officiis provident sed voluptatibus voluptas est inventore error aut optio facilis id velit nobis. 
            Et consequatur mollitia laboriosam dolore et eius necessitatibus ad voluptas ducimus est voluptatem veritatis. 
            Hic molestiae quas cum aperiam velit nam facere tenetur in nisi omnis quo aliquam accusamus aut minus nulla eos velit voluptas. 
            Et nobis facere vel dolorum dolores est vero dolorem eos aliquid sint qui voluptatum quam est tempore officiis! 
            Et pariatur atque et provident aperiam et quibusdam quaerat ut rerum suscipit et minus quas et similique quia eum illum possimus. 
            Est dolorem quia a dolores iste qui itaque quis aut fugit magni.",
            'total_weight' => 2000,
        ]);

        Quantity::create([
            'quantity'=> 200,
            'command_id'=> 1,
            'recipe_id' => 1,
        ]);

        Quantity::create([
            'quantity'=> 1200,
            'command_id'=> 2,
            'recipe_id' => 1,
        ]);

        Quantity::create([
            'quantity'=> 300,
            'command_id'=> 4,
            'recipe_id' => 1,
        ]);

        Quantity::create([
            'quantity'=> 300,
            'command_id'=> 9,
            'recipe_id' => 1,
        ]);
    }
}