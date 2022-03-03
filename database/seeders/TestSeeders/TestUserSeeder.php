<?php

namespace Database\Seeders\TestSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id' => TestDatabaseSeeder::TESTENV_USER_ID,
            'username' => TestDatabaseSeeder::TESTENV_USERNAME,
            'email' => TestDatabaseSeeder::TESTENV_EMAIL,
            'password' => Hash::make(TestDatabaseSeeder::TESTENV_PASSWORD),
        ]);
    }
}
