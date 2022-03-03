<?php

namespace Database\Seeders\TestSeeders;

use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Define constants for the dev User
     */
    public const TESTENV_USER_ID = 1;
    public const TESTENV_USERNAME = "Test";
    public const TESTENV_EMAIL = "test@test.com";
    public const TESTENV_PASSWORD = "testpassword";

    /**
     * Seed the test database with random commands and stocks products
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
        $this->call([
            TestUserSeeder::class,
            TestStockSeeder::class,
            TestRecipeSeeder::class,
            TestMenuSeeder::class,
        ]);
    }
}
