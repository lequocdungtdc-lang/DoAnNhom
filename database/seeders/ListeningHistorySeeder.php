<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ListeningHistorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('listening_history')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $songIds = DB::table('songs')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        if (empty($songIds) || empty($userIds)) {
            $this->command->warn('Cần có ít nhất 1 bài hát và 1 user để seed listening_history.');
            return;
        }

        $data = [];
        $now = Carbon::now();

        // Tạo dữ liệu cho 3 năm: năm hiện tại, năm trước, 2 năm trước
        for ($yearOffset = 0; $yearOffset <= 2; $yearOffset++) {
            $year = $now->year - $yearOffset;

            $maxMonth = ($yearOffset === 0) ? $now->month : 12;

            for ($month = 1; $month <= $maxMonth; $month++) {
                // Mỗi tháng tạo 30-80 lượt nghe ngẫu nhiên
                $count = rand(30, 80);

                for ($i = 0; $i < $count; $i++) {
                    $day = rand(1, Carbon::create($year, $month)->daysInMonth);
                    $hour = rand(0, 23);
                    $minute = rand(0, 59);

                    $listenedAt = Carbon::create($year, $month, $day, $hour, $minute, rand(0, 59));

                    $data[] = [
                        'user_id' => $userIds[array_rand($userIds)],
                        'song_id' => $songIds[array_rand($songIds)],
                        'listened_seconds' => rand(30, 300),
                        'has_counted' => 1,
                        'listened_at' => $listenedAt,
                        'status' => 1,
                        'created_at' => $listenedAt,
                        'updated_at' => $listenedAt,
                    ];
                }
            }
        }

        // Insert theo batch 500 records
        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('listening_history')->insert($chunk);
        }

        $this->command->info('Đã tạo ' . count($data) . ' bản ghi listening_history cho 3 năm gần nhất.');
    }
}
