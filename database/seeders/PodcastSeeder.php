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

        ];

        foreach ($podcasts as $podcast) {
            Podcast::create($podcast);
        }
    }
}