<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'sala',
            'email' => 'salhamaatouk@example.com',
            'password' => bcrypt('password'),
        ]);

        
        echo "User ID: " . $user->id . "\n";
    }
}

