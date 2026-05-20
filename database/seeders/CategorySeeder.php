<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Artist;
use App\Models\Categories;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert(
            [
                [
                    'name' => 'Nhạc Pop',
                    'group_name' => 'Việt Nam',
                    'image' => 'https://picsum.photos/seed/pop/400/240',
                    'description' => 'Những ca khúc pop dễ nghe và phổ biến.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Nhạc Ballad',
                    'group_name' => 'Tình cảm',
                    'image' => 'https://picsum.photos/seed/ballad/400/240',
                    'description' => 'Các bài hát nhẹ nhàng, cảm xúc.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Nhạc EDM',
                    'group_name' => 'Sôi động',
                    'image' => 'https://picsum.photos/seed/edm/400/240',
                    'description' => 'Âm nhạc điện tử dành cho không khí sôi động.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Nhạc Indie',
                    'group_name' => 'Chill',
                    'image' => 'https://picsum.photos/seed/indie/400/240',
                    'description' => 'Giai điệu tự do, cá tính và thư giãn.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc Acoustic',
                    'group_name' => 'Thư giãn',
                    'image' => 'https://picsum.photos/seed/acoustic/400/240',
                    'description' => 'Những bản nhạc mộc mạc với guitar và piano.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc Rock',
                    'group_name' => 'Mạnh mẽ',
                    'image' => 'https://picsum.photos/seed/rock/400/240',
                    'description' => 'Các ca khúc rock đầy năng lượng và cảm xúc.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc Rap',
                    'group_name' => 'Hip Hop',
                    'image' => 'https://picsum.photos/seed/rap/400/240',
                    'description' => 'Những bài rap với flow và lyric ấn tượng.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc Jazz',
                    'group_name' => 'Cổ điển',
                    'image' => 'https://picsum.photos/seed/jazz/400/240',
                    'description' => 'Giai điệu jazz sang trọng và ngẫu hứng.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc US-UK',
                    'group_name' => 'Quốc tế',
                    'image' => 'https://picsum.photos/seed/usuk/400/240',
                    'description' => 'Các bài hát nổi tiếng đến từ US-UK.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc Hàn',
                    'group_name' => 'KPOP',
                    'image' => 'https://picsum.photos/seed/kpop/400/240',
                    'description' => 'Những ca khúc KPOP đang thịnh hành.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc Nhật',
                    'group_name' => 'JPOP',
                    'image' => 'https://picsum.photos/seed/jpop/400/240',
                    'description' => 'Âm nhạc Nhật Bản với nhiều phong cách đa dạng.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc Thiếu Nhi',
                    'group_name' => 'Gia đình',
                    'image' => 'https://picsum.photos/seed/kids/400/240',
                    'description' => 'Những bài hát vui nhộn dành cho trẻ em.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'name' => 'Nhạc Không Lời',
                    'group_name' => 'Relax',
                    'image' => 'https://picsum.photos/seed/instrumental/400/240',
                    'description' => 'Âm nhạc không lời giúp tập trung và thư giãn.',
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
