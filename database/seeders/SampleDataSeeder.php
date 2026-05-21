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


        DB::table('song_views')->delete();

        DB::table('news')->delete();

        DB::table('artists')->delete();

        DB::table('albums')->delete();




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
            [
                'title' => 'Tiêu đề tin tức mẫu 1',
                'slug' => 'tieu-de-tin-tuc-mau-1', // <-- Thêm dòng này
                'content' => 'Nội dung chi tiết của tin tức mẫu 1',
                'status' => 'published', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'title' => 'Tiêu đề tin tức mẫu 2',
                'slug' => 'tieu-de-tin-tuc-mau-2', // <-- Thêm dòng này
                'content' => 'Nội dung chi tiết của tin tức mẫu 2',
                'status' => 'published', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);


        $user = User::where('email', 'user@gmail.com')->first();


      



        $this->command?->info('Đã tạo dữ liệu mẫu cho users, categories, artists, albums, songs và các bảng mới.');
    }
}