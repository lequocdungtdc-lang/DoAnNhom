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
        DB::table('news')->delete();
        DB::table('artists')->delete();
        DB::table('albums')->delete();
        DB::table('categories')->delete();

       

        $categories = collect([
            [
                'name' => 'Nhạc Pop',
                'group_name' => 'Việt Nam',
                'image' => 'https://picsum.photos/seed/pop/400/240',
                'description' => 'Những ca khúc pop dễ nghe và phổ biến.',
                'status' => true,
            ],
            [
                'name' => 'Nhạc Ballad',
                'group_name' => 'Tình cảm',
                'image' => 'https://picsum.photos/seed/ballad/400/240',
                'description' => 'Các bài hát nhẹ nhàng, cảm xúc.',
                'status' => true,
            ],
            [
                'name' => 'Nhạc EDM',
                'group_name' => 'Sôi động',
                'image' => 'https://picsum.photos/seed/edm/400/240',
                'description' => 'Âm nhạc điện tử dành cho không khí sôi động.',
                'status' => true,
            ],
            [
                'name' => 'Nhạc Indie',
                'group_name' => 'Chill',
                'image' => 'https://picsum.photos/seed/indie/400/240',
                'description' => 'Giai điệu tự do, cá tính và thư giãn.',
                'status' => true,
            ],
        ])->map(fn($item) => Categories::create($item));

        $artists = collect([
            [
                'name' => 'Vũ.',
                'image' => 'https://picsum.photos/seed/vu/300/300',
                'category_id' => $categories[3]->id,
                'status' => true,
            ],
            [
                'name' => 'Sơn Tùng M-TP',
                'image' => 'https://picsum.photos/seed/mtp/300/300',
                'category_id' => $categories[0]->id,
                'status' => true,
            ],
            [
                'name' => 'MIN',
                'image' => 'https://picsum.photos/seed/min/300/300',
                'category_id' => $categories[1]->id,
                'status' => true,
            ],
            [
                'name' => 'Da LAB',
                'image' => 'https://picsum.photos/seed/dalab/300/300',
                'category_id' => $categories[2]->id,
                'status' => true,
            ],
            [
                'name' => 'HIEUTHUHAI',
                'image' => 'https://picsum.photos/seed/hieuthuhai/300/300',
                'category_id' => $categories[2]->id,
                'status' => true,
            ],
            [
                'name' => 'Đen Vâu',
                'image' => 'https://picsum.photos/seed/denvau/300/300',
                'category_id' => $categories[1]->id,
                'status' => true,
            ],
            [
                'name' => 'Duy Mạnh',
                'image' => 'https://picsum.photos/seed/duymanh/300/300',
                'category_id' => $categories[0]->id,
                'status' => true,
            ],
        ])->map(fn($item) => Artist::create($item));

        $albums = collect([
            [
                'title' => 'Mùa Hè Cũ',
                'artist_name' => 'Vũ.',
                'cover_image' => 'https://picsum.photos/seed/album1/400/400',
                'status' => true,
            ],
            [
                'title' => 'Sky Tour',
                'artist_name' => 'Sơn Tùng M-TP',
                'cover_image' => 'https://picsum.photos/seed/album2/400/400',
                'status' => true,
            ],
            [
                'title' => '50/50',
                'artist_name' => 'MIN',
                'cover_image' => 'https://picsum.photos/seed/album3/400/400',
                'status' => true,
            ],
        ])->map(fn($item) => Album::create($item));


        News::insert([
            ['status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

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
