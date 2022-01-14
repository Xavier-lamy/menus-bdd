<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with random commands and stocks products
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StockSeeder::class,
        ]);
    }
}
