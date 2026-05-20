<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Podcast;

class PodcastSeeder extends Seeder
{
    public function run(): void
    {
        $podcasts = [

            [
                'title' => 'Tâm Sự Đêm Khuya',
                'description' => 'Podcast chia sẻ những câu chuyện cuộc sống và cảm xúc.',
                'audio_file' => 'podcasts/tam-su-dem-khuya.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast1/500/300',
                'duration' => 1250,
                'views' => 1657,
                'status' => true,
            ],

            [
                'title' => 'Cà Phê Cuối Tuần',
                'description' => 'Những buổi trò chuyện nhẹ nhàng cuối tuần.',
                'audio_file' => 'podcasts/ca-phe-cuoi-tuan.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast2/500/300',
                'duration' => 980,
                'views' => 700,
                'status' => true,
            ],

            [
                'title' => 'Hành Trình Lập Trình',
                'description' => 'Chia sẻ kinh nghiệm học code và làm dự án.',
                'audio_file' => 'podcasts/hanh-trinh-lap-trinh.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast3/500/300',
                'duration' => 2100,
                'views' => 2850,
                'status' => true,
            ],

            [
                'title' => 'Chuyện Người Trẻ',
                'description' => 'Góc nhìn và câu chuyện dành cho giới trẻ.',
                'audio_file' => 'podcasts/chuyen-nguoi-tre.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast4/500/300',
                'duration' => 1540,
                'views' => 4442,
                'status' => false,
            ],

            [
                'title' => 'Midnight Stories',
                'description' => 'English podcast about late-night thoughts.',
                'audio_file' => 'podcasts/midnight-stories.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast5/500/300',
                'duration' => 1870,
                'views' => 4312,
                'status' => true,
            ],
            [
                'title' => 'Những Ngày Bình Yên',
                'description' => 'Podcast kể về những khoảnh khắc giản dị trong cuộc sống.',
                'audio_file' => 'podcasts/nhung-ngay-binh-yen.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast6/500/300',
                'duration' => 1320,
                'views' => 1920,
                'status' => true,
            ],

            [
                'title' => 'Góc Nhìn Công Nghệ',
                'description' => 'Cập nhật xu hướng công nghệ và AI mới nhất.',
                'audio_file' => 'podcasts/goc-nhin-cong-nghe.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast7/500/300',
                'duration' => 2480,
                'views' => 5210,
                'status' => true,
            ],

            [
                'title' => 'Hành Trình Tuổi Trẻ',
                'description' => 'Những trải nghiệm đáng nhớ của tuổi trẻ.',
                'audio_file' => 'podcasts/hanh-trinh-tuoi-tre.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast8/500/300',
                'duration' => 1740,
                'views' => 3150,
                'status' => true,
            ],

            [
                'title' => 'Đêm Không Ngủ',
                'description' => 'Những câu chuyện dành cho những ai còn thức khuya.',
                'audio_file' => 'podcasts/dem-khong-ngu.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast9/500/300',
                'duration' => 1430,
                'views' => 2801,
                'status' => false,
            ],

            [
                'title' => 'Startup Việt',
                'description' => 'Chia sẻ kinh nghiệm khởi nghiệp và kinh doanh.',
                'audio_file' => 'podcasts/startup-viet.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast10/500/300',
                'duration' => 2690,
                'views' => 6200,
                'status' => true,
            ],

            [
                'title' => 'Ký Ức Thanh Xuân',
                'description' => 'Những câu chuyện và kỷ niệm tuổi học trò.',
                'audio_file' => 'podcasts/ky-uc-thanh-xuan.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast11/500/300',
                'duration' => 1580,
                'views' => 3410,
                'status' => true,
            ],

            [
                'title' => 'The Coding Life',
                'description' => 'English podcast for developers and tech lovers.',
                'audio_file' => 'podcasts/the-coding-life.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast12/500/300',
                'duration' => 2330,
                'views' => 4870,
                'status' => true,
            ],

            [
                'title' => 'Sống Chậm Lại',
                'description' => 'Podcast truyền cảm hứng sống tích cực và cân bằng.',
                'audio_file' => 'podcasts/song-cham-lai.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast13/500/300',
                'duration' => 1210,
                'views' => 2140,
                'status' => true,
            ],

            [
                'title' => 'Radio Một Mình',
                'description' => 'Những tâm sự dành cho người cô đơn.',
                'audio_file' => 'podcasts/radio-mot-minh.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast14/500/300',
                'duration' => 1650,
                'views' => 3985,
                'status' => false,
            ],

            [
                'title' => 'Morning Motivation',
                'description' => 'Daily motivation podcast to start your day.',
                'audio_file' => 'podcasts/morning-motivation.mp3',
                'thumbnail' => 'https://picsum.photos/seed/podcast15/500/300',
                'duration' => 970,
                'views' => 2750,
                'status' => true,
            ],

        ];

        foreach ($podcasts as $podcast) {
            Podcast::create($podcast);
        }
    }
}
