<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Artist;
use App\Models\Categories;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Categories::all();

        DB::table('artists')->insert(
            [
                [
                    'name' => 'Vũ.',
                    'image' => 'https://picsum.photos/seed/vu/300/300',
                    'category_id' => $categories[3]->id,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sơn Tùng M-TP',
                    'image' => 'https://picsum.photos/seed/mtp/300/300',
                    'category_id' => $categories[0]->id,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'MIN',
                    'image' => 'https://picsum.photos/seed/min/300/300',
                    'category_id' => $categories[1]->id,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Da LAB',
                    'image' => 'https://picsum.photos/seed/dalab/300/300',
                    'category_id' => $categories[2]->id,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'HIEUTHUHAI',
                    'image' => 'https://picsum.photos/seed/hth/300/300',
                    'category_id' => $categories[4]->id,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Đen Vâu',
                    'image' => 'https://picsum.photos/seed/denvau/300/300',
                    'category_id' => $categories[1]->id,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Duy Mạnh',
                    'image' => 'https://picsum.photos/seed/duymanh/300/300',
                    'category_id' => $categories[0]->id,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Thái Đinh',
                    'image' => 'https://picsum.photos/seed/taidinh/300/300',
                    'category_id' => $categories[0]->id,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
