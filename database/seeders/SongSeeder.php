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

        if ($artists->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Skipping SongSeeder: artists or categories table is empty.');
            return;
        }

        $maxArtist = $artists->count() - 1;
        $maxCategory = $categories->count() - 1;

        DB::table('songs')->insert([
            [
                'title' => 'Bước Qua Nhau',
                'artist_id' => $artists[min(0, $maxArtist)]->id,
                'category_id' => $categories[min(3, $maxCategory)]->id,
                'audio_file' => 'songs/buoc-qua-nhau.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song1/500/300',
                'listen_count' => 120120,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Có Chắc Yêu Là Đây',
                'artist_id' => $artists[min(2, $maxArtist)]->id,
                'category_id' => $categories[min(3, $maxCategory)]->id,
                'audio_file' => 'songs/co-chac-yeu-la-day.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song7/500/300',
                'listen_count' => 150653,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Lạ Lùng',
                'artist_id' => $artists[min(1, $maxArtist)]->id,
                'category_id' => $categories[min(1, $maxCategory)]->id,
                'audio_file' => 'songs/la-lung.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song3/500/300',
                'listen_count' => 104067,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Nơi Này Có Anh',
                'artist_id' => $artists[min(1, $maxArtist)]->id,
                'category_id' => $categories[min(0, $maxCategory)]->id,
                'audio_file' => 'songs/noi-nay-co-anh.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song4/500/300',
                'listen_count' => 212000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Trên Tình Bạn Dưới Tình Yêu',
                'artist_id' => $artists[min(2, $maxArtist)]->id,
                'category_id' => $categories[min(1, $maxCategory)]->id,
                'audio_file' => 'songs/tren-tinh-ban-duoi-tinh-yeu.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song5/500/300',
                'listen_count' => 110040,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Thanh Xuân',
                'artist_id' => $artists[min(3, $maxArtist)]->id,
                'category_id' => $categories[min(2, $maxCategory)]->id,
                'audio_file' => 'songs/thanh-xuan.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song6/500/300',
                'listen_count' => 59010,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Thức giấc',
                'artist_id' => $artists[min(3, $maxArtist)]->id,
                'category_id' => $categories[min(2, $maxCategory)]->id,
                'audio_file' => 'songs/thuc-giac.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song8/500/300',
                'listen_count' => 13740,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '10 Ngàn năm',
                'artist_id' => $artists[min(5, $maxArtist)]->id,
                'category_id' => $categories[min(3, $maxCategory)]->id,
                'audio_file' => 'songs/10-ngan-nam.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song9/500/300',
                'listen_count' => 42740,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '2 Triệu năm',
                'artist_id' => $artists[min(5, $maxArtist)]->id,
                'category_id' => $categories[min(3, $maxCategory)]->id,
                'audio_file' => 'songs/2-trieu-nam.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song10/500/300',
                'listen_count' => 38560,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tình em là đại dương',
                'artist_id' => $artists[min(6, $maxArtist)]->id,
                'category_id' => $categories[min(0, $maxCategory)]->id,
                'audio_file' => 'songs/tinh-em-la-dai-duong.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song11/500/300',
                'listen_count' => 38560,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Phố không em',
                'artist_id' => $artists[min(7, $maxArtist)]->id,
                'category_id' => $categories[min(0, $maxCategory)]->id,
                'audio_file' => 'songs/pho-khong-em.mp3',
                'thumbnail' => 'https://picsum.photos/seed/song12/500/300',
                'listen_count' => 23560,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Đi qua mùa hạ',
                'artist_id' => $artists[min(7, $maxArtist)]->id,
                'category_id' => $categories[min(0, $maxCategory)]->id,
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
