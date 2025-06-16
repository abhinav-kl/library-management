<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'username' => 'admin_user',
            'name' => 'Admin User',
            'user_type' => 'ADM',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // default password
            'remember_token' => Str::random(10),
        ]);

        // Regular users
        $users = [
            ['username' => 'jdoe', 'name' => 'John Doe', 'email' => 'jdoe@example.com'],
            ['username' => 'asmith', 'name' => 'Alice Smith', 'email' => 'asmith@example.com'],
            ['username' => 'bwayne', 'name' => 'Bruce Wayne', 'email' => 'bwayne@example.com'],
            ['username' => 'ckent', 'name' => 'Clark Kent', 'email' => 'ckent@example.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'username' => $user['username'],
                'name' => $user['name'],
                'user_type' => 'USR',
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // default password
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
