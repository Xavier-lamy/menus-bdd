<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\DevSeeders\UserSeeder;
use Database\Seeders\DevSeeders\StockSeeder;
use Database\Seeders\DevSeeders\RecipeSeeder;
use Database\Seeders\DevSeeders\MenuSeeder;
use App\Models\Option;

class DatabaseSeeder extends Seeder
{
    /**
     * Define constants for the dev User
     */
    public const DEVENV_USER_ID = 1;
    public const DEVENV_USERNAME = "AdminTest";
    public const DEVENV_EMAIL = "admin@test.com";
    public const DEVENV_PASSWORD = "azertyuiop";

    /**
     * Seeder used for dev environnement test create a user and a bunch of products
     * Seed the application's database with random commands and stocks products
     *
     * @return void
     */
    public function run()
    {
        //Seed with basic options in any environment(dev or prod)
        foreach(Option::STARTING_OPTIONS as $option){
            Option::create([
                'option_type' => $option['option_type'],
                'options' => $option['options'],
            ]);
        }

        if (app()->environment('local')) {
            //Call dev seeders if app env is local
            $this->call([
                UserSeeder::class,
                StockSeeder::class,
                RecipeSeeder::class,
                MenuSeeder::class,
            ]);
        }

    }
}
