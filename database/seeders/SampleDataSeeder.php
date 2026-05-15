<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Categories;
use App\Models\Comment;
use App\Models\ListeningHistory;
use App\Models\News;
use App\Models\SongUserLike;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('song_user_likes')->delete();
        DB::table('comments')->delete();
        DB::table('listening_history')->delete();
        DB::table('song_views')->delete();
        DB::table('artists')->delete();
        DB::table('albums')->delete();
        DB::table('categories')->delete();

       

        $categories = collect([
            [
                'tentheloai' => 'Nhạc Pop',
                'nhom' => 'Việt Nam',
                'image' => 'https://picsum.photos/seed/pop/400/240',
                'description' => 'Những ca khúc pop dễ nghe và phổ biến.',
                'status' => true,
            ],
            [
                'tentheloai' => 'Nhạc Ballad',
                'nhom' => 'Tình cảm',
                'image' => 'https://picsum.photos/seed/ballad/400/240',
                'description' => 'Các bài hát nhẹ nhàng, cảm xúc.',
                'status' => true,
            ],
            [
                'tentheloai' => 'Nhạc EDM',
                'nhom' => 'Sôi động',
                'image' => 'https://picsum.photos/seed/edm/400/240',
                'description' => 'Âm nhạc điện tử dành cho không khí sôi động.',
                'status' => true,
            ],
            [
                'tentheloai' => 'Nhạc Indie',
                'nhom' => 'Chill',
                'image' => 'https://picsum.photos/seed/indie/400/240',
                'description' => 'Giai điệu tự do, cá tính và thư giãn.',
                'status' => true,
            ],
        ])->map(fn($item) => Categories::create($item));

        $artists = collect([
            [
                'name_artist' => 'Vũ.',
                'image_artist' => 'https://picsum.photos/seed/vu/300/300',
                'category_id' => $categories[3]->id,
                'status' => true,
            ],
            [
                'name_artist' => 'Sơn Tùng M-TP',
                'image_artist' => 'https://picsum.photos/seed/mtp/300/300',
                'category_id' => $categories[0]->id,
                'status' => true,
            ],
            [
                'name_artist' => 'MIN',
                'image_artist' => 'https://picsum.photos/seed/min/300/300',
                'category_id' => $categories[1]->id,
                'status' => true,
            ],
            [
                'name_artist' => 'Da LAB',
                'image_artist' => 'https://picsum.photos/seed/dalab/300/300',
                'category_id' => $categories[2]->id,
                'status' => true,
            ],
            [
                'name_artist' => 'HIEUTHUHAI',
                'image_artist' => 'https://picsum.photos/seed/hieuthuhai/300/300',
                'category_id' => $categories[2]->id,
                'status' => true,
            ],
            [
                'name_artist' => 'Đen Vâu',
                'image_artist' => 'https://picsum.photos/seed/denvau/300/300',
                'category_id' => $categories[1]->id,
                'status' => true,
            ],
            [
                'name_artist' => 'Duy Mạnh',
                'image_artist' => 'https://picsum.photos/seed/duymanh/300/300',
                'category_id' => $categories[0]->id,
                'status' => true,
            ],
        ])->map(fn($item) => Artist::create($item));

        $albums = collect([
            [
                'ten_album' => 'Mùa Hè Cũ',
                'nghe_si' => 'Vũ.',
                'anh_bia' => 'https://picsum.photos/seed/album1/400/400',
                'status' => true,
            ],
            [
                'ten_album' => 'Sky Tour',
                'nghe_si' => 'Sơn Tùng M-TP',
                'anh_bia' => 'https://picsum.photos/seed/album2/400/400',
                'status' => true,
            ],
            [
                'ten_album' => '50/50',
                'nghe_si' => 'MIN',
                'anh_bia' => 'https://picsum.photos/seed/album3/400/400',
                'status' => true,
            ],
        ])->map(fn($item) => Album::create($item));



        $user = User::where('email', 'user@gmail.com')->first();

        SongUserLike::insert([
            ['created_at' => now(), 'updated_at' => now()],
            ['created_at' => now(), 'updated_at' => now()],
        ]);

        Comment::insert([
            ['status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        ListeningHistory::insert([
            ['status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->command?->info('Đã tạo dữ liệu mẫu cho users, categories, artists, albums, songs và các bảng mới.');
    }
}
