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
            [
                'fullname' => 'Tran Minh Quan',
                'email' => 'quan@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '0900000005',
                'address' => 'Ho Chi Minh',
                'avatar' => 'https://picsum.photos/seed/user2/300/300',
                'numb' => 0,
            ],
            [
                'fullname' => 'Le Thu Trang',
                'email' => 'trang@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '0900000006',
                'address' => 'Da Nang',
                'avatar' => 'https://picsum.photos/seed/user3/300/300',
                'numb' => 0,
            ],
            [
                'fullname' => 'Pham Gia Bao',
                'email' => 'bao@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '0900000007',
                'address' => 'Hai Phong',
                'avatar' => 'https://picsum.photos/seed/user4/300/300',
                'numb' => 0,
            ],
            [
                'fullname' => 'Vo Thanh Dat',
                'email' => 'dat@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'inactive',
                'phone' => '0900000008',
                'address' => 'Vung Tau',
                'avatar' => 'https://picsum.photos/seed/user5/300/300',
                'numb' => 0,
            ],
            [
                'fullname' => 'Dang Ngoc Han',
                'email' => 'han@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '0900000009',
                'address' => 'Hue',
                'avatar' => 'https://picsum.photos/seed/user6/300/300',
                'numb' => 0,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
