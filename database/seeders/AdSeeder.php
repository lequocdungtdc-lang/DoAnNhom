<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại để xóa sạch dữ liệu cũ mà không bị lỗi ràng buộc
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ads')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Danh sách tên quảng cáo mẫu
        $adNames = [
            'Siêu Sale Sập Sàn - Black Friday',
            'Khóa Học Laravel Pro Cho Người Mới',
            'Đăng Ký Premium - Nghe Nhạc Không Quảng Cáo',
            'Bộ Sưu Tập Giày Thể Thao Mùa Hè',
            'Ra Mắt Album Mới Của Vũ Trần - Nghe Ngay',
            'Sự Kiện Live Concert Thanh Âm Cuối Cùng',
            'Ứng Dụng Nghe Nhạc Số 1 Việt Nam',
            'Tai Nghe Bluetooth Chống Ồn Cao Cấp',
        ];

        // Danh sách mô tả quảng cáo mẫu
        $descriptions = [
            'Giảm giá lên đến 50% cho tất cả các mặt hàng duy nhất trong tuần này. Số lượng có hạn!',
            'Trở thành lập trình viên backend chuyên nghiệp cùng chuyên gia. Đăng ký nhận ưu đãi 30%.',
            'Trải nghiệm âm nhạc chất lượng cao, không lo gián đoạn. Thử nghiệm miễn phí 30 ngày đầu tiên.',
            'Thiết kế năng động, chất liệu êm ái, đồng hành cùng bạn trên mọi nẻo đường hành trình.',
            'Thưởng thức trọn vẹn các ca khúc mới nhất độc quyền trên nền tảng của chúng tôi.',
        ];

        // Danh sách link liên kết mẫu
        $links = [
            'https://laravel.com',
            'https://google.com',
            'https://spotify.com',
            'https://github.com',
        ];

        // Lấy danh sách ảnh quảng cáo từ thư mục storage/app/public/ad_images
        $images = Storage::disk('public')->files('ad_images');

        if (empty($images)) {
            // Nếu bạn chưa chuẩn bị ảnh trong thư mục, hệ thống sẽ báo cảnh báo và dùng chuỗi mặc định
            $this->command->warn('Không tìm thấy ảnh trong thư mục ad_images. Dùng ảnh mặc định.');
            $images = ['default_ad.jpg'];
        }

        $data = [];

        // Tạo vòng lặp sinh ra 30 dữ liệu quảng cáo ngẫu nhiên
        for ($i = 0; $i < 30; $i++) {
            $randomName = $adNames[array_rand($adNames)];
            $randomDesc = $descriptions[array_rand($descriptions)];
            $randomLink = $links[array_rand($links)];
            $randomImage = $images[array_rand($images)];

            $data[] = [
                'name'        => $randomName . ' #' . ($i + 1), // Thêm số để phân biệt
                'media_type'  => basename($randomImage),         // Lưu tên file ảnh
                'link_url'    => $randomLink,
                'is_active'   => rand(0, 1),                     // Ngẫu nhiên Bật (1) hoặc Tắt (0)
                'description' => $randomDesc,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        // Bắn toàn bộ dữ liệu vào bảng ads
        DB::table('ads')->insert($data);
        $this->command->info('Đã tạo thành công 30 bản ghi dữ liệu mẫu cho bảng quảng cáo!');
    }
}