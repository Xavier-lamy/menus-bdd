<?php

namespace Database\Seeders\DevSeeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;

class UserSeeder extends Seeder {
    
    /**
     * Create a fake user with Id 1 for recipe creation
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id' => DatabaseSeeder::DEVENV_USER_ID,
            'username' => DatabaseSeeder::DEVENV_USERNAME,
            'email' => DatabaseSeeder::DEVENV_EMAIL,
            'password' => Hash::make(DatabaseSeeder::DEVENV_PASSWORD),
        ]);

        addStartingOptionsToUser($user);
    }
}