<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Categories;
use App\Models\Comment;
use App\Models\ListeningHistory;
use App\Models\News;
use App\Models\Song;
use App\Models\SongUserLike;
use App\Models\SongView;
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
        DB::table('songs')->delete();
        DB::table('artists')->delete();
        DB::table('albums')->delete();
        DB::table('categories')->delete();

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'fullname' => 'Quản trị viên mẫu',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'status' => 'active',
                'phone' => '0900000001',
                'address' => 'Thành phố Hồ Chí Minh',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'fullname' => 'Người dùng mẫu',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '0900000002',
                'address' => 'Hà Nội',
            ]
        );

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

        $songs = collect([
            [
                'tenbaihat' => 'Bước Qua Nhau',
                'nghesi' => $artists[0]->id,
                'theloai' => $categories[3]->id,
                'file_amthanh' => 'songs/buoc-qua-nhau.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song1/500/300',
                'status' => true,
            ],
            [
                'tenbaihat' => 'Có Chắc Yêu Là Đây',
                'nghesi' => $artists[2]->id,
                'theloai' => $categories[3]->id,
                'file_amthanh' => 'songs/co-chac-yeu-la-day.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song7/500/300',
                'status' => true,
            ],
            [
                'tenbaihat' => 'Lạ Lùng',
                'nghesi' => $artists[1]->id,
                'theloai' => $categories[1]->id,
                'file_amthanh' => 'songs/la-lung.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song3/500/300',
                'status' => true,
            ],
            [
                'tenbaihat' => 'Nơi Này Có Anh',
                'nghesi' => $artists[1]->id,
                'theloai' => $categories[0]->id,
                'file_amthanh' => 'songs/noi-nay-co-anh.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song4/500/300',
                'status' => true,
            ],
            [
                'tenbaihat' => 'Trên Tình Bạn Dưới Tình Yêu',
                'nghesi' => $artists[2]->id,
                'theloai' => $categories[1]->id,
                'file_amthanh' => 'songs/tren-tinh-ban-duoi-tinh-yeu.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song5/500/300',
                'status' => true,
            ],
            [
                'tenbaihat' => 'Thanh Xuân',
                'nghesi' => $artists[3]->id,
                'theloai' => $categories[2]->id,
                'file_amthanh' => 'songs/thanh-xuan.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song6/500/300',
                'status' => true,
            ],
            [
                'tenbaihat' => 'Thức giấc',
                'nghesi' => $artists[3]->id,
                'theloai' => $categories[2]->id,
                'file_amthanh' => 'songs/thuc-giac.mp3',
                'anh_daidien' => 'https://picsum.photos/seed/song8/500/300',
                'status' => true,
            ],
        ])->map(fn($item) => Song::create($item));

        News::insert([
            ['status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        SongView::insert($songs->map(fn($song) => [
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ])->all());

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
