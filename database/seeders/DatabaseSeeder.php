<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\DevSeeders\DevUserSeeder;
use Database\Seeders\DevSeeders\DevStockSeeder;
use Database\Seeders\DevSeeders\DevRecipeSeeder;
use Database\Seeders\DevSeeders\DevMenuSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeder used for dev environnement test create a user and a bunch of products
     * Seed the application's database with random commands and stocks products
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DevUserSeeder::class,
            DevStockSeeder::class,
            DevRecipeSeeder::class,
            DevMenuSeeder::class,
        ]);
    }
}
