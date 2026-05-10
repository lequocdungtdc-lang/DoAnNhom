<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categories;
use App\Models\Song;
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
        Categories::insert([
            [
                'tentheloai' => 'Nhạc Pop',
                'nhom' => 'Âm nhạc',
                'image' => 'pop.jpg',
                'description' => 'Dòng nhạc phổ biến, dễ nghe',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tentheloai' => 'Nhạc Rock',
                'nhom' => 'Âm nhạc',
                'image' => 'rock.jpg',
                'description' => 'Nhạc mạnh, sử dụng guitar điện',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tentheloai' => 'Nhạc EDM',
                'nhom' => 'Âm nhạc',
                'image' => 'edm.jpg',
                'description' => 'Nhạc điện tử sôi động',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tentheloai' => 'Nhạc Rap',
                'nhom' => 'Âm nhạc',
                'image' => 'rap.jpg',
                'description' => 'Nhạc rap/hiphop',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tentheloai' => 'Nhạc Trữ Tình',
                'nhom' => 'Âm nhạc',
                'image' => 'trutinh.jpg',
                'description' => 'Nhạc nhẹ, cảm xúc',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
