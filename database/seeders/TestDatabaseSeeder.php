<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Seed the test database with random commands and stocks products
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TestStockSeeder::class,
            TestRecipeSeeder::class,
            TestMenuSeeder::class,
        ]);
    }
}
