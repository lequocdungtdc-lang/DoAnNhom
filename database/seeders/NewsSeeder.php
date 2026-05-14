<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::truncate(); // Xóa dữ liệu cũ

        // Tin thủ công
        News::create([
            'title' => 'Công nghệ AI đang thay đổi thế giới như thế nào năm 2026?',
            'slug' => 'ai-thay-doi-the-gioi-2026',
            'content' => '<p>Nội dung chi tiết về trí tuệ nhân tạo...</p>',
            'summary' => 'Trí tuệ nhân tạo tiếp tục phát triển mạnh mẽ trong năm 2026.',
            'category' => 'Công nghệ',
            'user_id' => 1,
            'status' => 'published',
        ]);

        News::create([
            'title' => 'Giá vàng hôm nay tăng kỷ lục mới',
            'slug' => 'gia-vang-tang-ky-luc',
            'content' => '<p>Chi tiết tin kinh tế...</p>',
            'summary' => 'Giá vàng trong nước và thế giới đồng loạt tăng mạnh.',
            'category' => 'Kinh tế',
            'user_id' => 1,
            'status' => 'published',
        ]);

        // Tạo thêm 10 tin ngẫu nhiên
        News::factory(10)->create(['status' => 'published']);
    }
}