<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'fullname' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'status' => 'active',
                'phone' => '0900000001',
                'address' => 'Thành phố Hồ Chí Minh',
                'avatar' => 'https://picsum.photos/seed/admin/300/300',
                'numb' => 0,
            ],
            [
                'fullname' => 'Test User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '0900000002',
                'address' => 'Hà Nội',
                'avatar' => 'https://picsum.photos/seed/user/300/300',
                'numb' => 0,
            ],
            [
                'fullname' => 'Dang Hoang Phuc',
                'email' => 'phuc@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '0900000003',
                'address' => 'Da Nang',
                'avatar' => 'https://picsum.photos/seed/user/300/300',
                'numb' => 0,
            ],
            [
                'fullname' => 'Nguyen Hoang Anh',
                'email' => 'anh@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '0900000004',
                'address' => 'Can Tho',
                'avatar' => 'https://picsum.photos/seed/user/300/300',
                'numb' => 0,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}