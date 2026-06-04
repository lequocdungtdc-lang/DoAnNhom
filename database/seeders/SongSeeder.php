<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Artist;
use App\Models\Categories;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artists = Artist::all();
        $categories = Categories::all();

        DB::table('songs')->insert([
            [
                'title' => 'Bước Qua Nhau',
                'artist_id' => $artists[0]->id,
                'category_id' => $categories[3]->id,
                'audio_file' => 'songs/8b9dd237-5c35-4d13-b654-72812351af19.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song1/500/300',
                'listen_count' => 120120,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Có Chắc Yêu Là Đây',
                'artist_id' => $artists[2]->id,
                'category_id' => $categories[3]->id,
                'audio_file' => 'songs/80de5f9c-a85d-4962-a53b-54fde108e321.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song7/500/300',
                'listen_count' => 150653,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Lạ Lùng',
                'artist_id' => $artists[1]->id,
                'category_id' => $categories[1]->id,
                'audio_file' => 'songs/99539de7-0235-4b42-b966-32152cf1103d.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song3/500/300',
                'listen_count' => 104067,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Nơi Này Có Anh',
                'artist_id' => $artists[1]->id,
                'category_id' => $categories[0]->id,
                'audio_file' => 'songs/a12b0fe4-1357-4cfe-9b0e-03c2787ab352.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song4/500/300',
                'listen_count' => 212000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Trên Tình Bạn Dưới Tình Yêu',
                'artist_id' => $artists[2]->id,
                'category_id' => $categories[1]->id,
                'audio_file' => 'songs/ab22ccc8-5807-4424-bb47-186a13ba56e6.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song5/500/300',
                'listen_count' => 110040,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Thanh Xuân',
                'artist_id' => $artists[3]->id,
                'category_id' => $categories[2]->id,
                'audio_file' => 'songs/b5051c5d-063e-4f09-96f7-311f46bcad80.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song6/500/300',
                'listen_count' => 59010,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Thức giấc',
                'artist_id' => $artists[3]->id,
                'category_id' => $categories[2]->id,
                'audio_file' => 'songs/d0b5844d-c1ab-4e85-a4d0-5eaad86e499f.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song8/500/300',
                'listen_count' => 13740,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '10 Ngàn năm',
                'artist_id' => $artists[5]->id,
                'category_id' => $categories[3]->id,
                'audio_file' => 'songs/d78928da-b30a-4562-ac9e-0d3ce16bbee3.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song9/500/300',
                'listen_count' => 42740,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '2 Triệu năm',
                'artist_id' => $artists[5]->id,
                'category_id' => $categories[3]->id,
                'audio_file' => 'songs/fcdf1cdd-f740-494f-9b8f-23227724d7d1.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song10/500/300',
                'listen_count' => 38560,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tình em là đại dương',
                'artist_id' => $artists[6]->id,
                'category_id' => $categories[0]->id,
                'audio_file' => 'songs/tinh-em-la-dai-duong.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song11/500/300',
                'listen_count' => 38560,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Phố không em',
                'artist_id' => $artists[7]->id,
                'category_id' => $categories[0]->id,
                'audio_file' => 'songs/pho-khong-em.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song12/500/300',
                'listen_count' => 23560,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Đi qua mùa hạ',
                'artist_id' => $artists[7]->id,
                'category_id' => $categories[0]->id,
                'audio_file' => 'songs/di-qua-mua-ha.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song13/500/300',
                'listen_count' => 76660,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
