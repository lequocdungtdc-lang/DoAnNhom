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
                'tenbaihat' => 'Bước Qua Nhau',
                'nghesi' => $artists[0]->id,
                'theloai' => $categories[3]->id,
                'file_amthanh' => 'songs/buoc-qua-nhau.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song1/500/300',
                'luot_nghe' => 120120,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenbaihat' => 'Có Chắc Yêu Là Đây',
                'nghesi' => $artists[2]->id,
                'theloai' => $categories[3]->id,
                'file_amthanh' => 'songs/co-chac-yeu-la-day.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song7/500/300',
                'luot_nghe' => 150653,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenbaihat' => 'Lạ Lùng',
                'nghesi' => $artists[1]->id,
                'theloai' => $categories[1]->id,
                'file_amthanh' => 'songs/la-lung.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song3/500/300',
                'luot_nghe' => 104067,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenbaihat' => 'Nơi Này Có Anh',
                'nghesi' => $artists[1]->id,
                'theloai' => $categories[0]->id,
                'file_amthanh' => 'songs/noi-nay-co-anh.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song4/500/300',
                'luot_nghe' => 212000,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenbaihat' => 'Trên Tình Bạn Dưới Tình Yêu',
                'nghesi' => $artists[2]->id,
                'theloai' => $categories[1]->id,
                'file_amthanh' => 'songs/tren-tinh-ban-duoi-tinh-yeu.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song5/500/300',
                'luot_nghe' => 110040,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenbaihat' => 'Thanh Xuân',
                'nghesi' => $artists[3]->id,
                'theloai' => $categories[2]->id,
                'file_amthanh' => 'songs/thanh-xuan.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song6/500/300',
                'luot_nghe' => 59010,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenbaihat' => 'Thức giấc',
                'nghesi' => $artists[3]->id,
                'theloai' => $categories[2]->id,
                'file_amthanh' => 'songs/thuc-giac.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song8/500/300',
                'luot_nghe' => 13740,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}