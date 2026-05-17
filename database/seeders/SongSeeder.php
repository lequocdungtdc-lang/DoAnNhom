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
                'audio_file' => 'songs/buoc-qua-nhau.mp3',
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
                'audio_file' => 'songs/co-chac-yeu-la-day.mp3',
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
                'audio_file' => 'songs/la-lung.mp3',
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
                'audio_file' => 'songs/noi-nay-co-anh.mp3',
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
                'audio_file' => 'songs/tren-tinh-ban-duoi-tinh-yeu.mp3',
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
                'audio_file' => 'songs/thanh-xuan.mp3',
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
                'audio_file' => 'songs/thuc-giac.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song8/500/300',
                'listen_count' => 13740,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}