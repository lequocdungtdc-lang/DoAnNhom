<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       User::factory()->createMany([
            [
                'fullname' => 'Test User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'fullname' => 'Test User 2',
                'email' => 'admin2@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
                'status' => 'pending',
            ],
            [
                'fullname' => 'Test User 3',
                'email' => 'admin3@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
                'status' => 'pending',
            ],
        ]);
    }
}
