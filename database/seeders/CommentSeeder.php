<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\News;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $news = News::all();

        if ($users->isEmpty() || $news->isEmpty()) {
            $this->command->warn('Skipping CommentSeeder: users or news table is empty.');
            return;
        }

        $maxUser = $users->count() - 1;
        $maxNews = $news->count() - 1;

        $comments = [

            [
                'user_id' => $users[min(0, $maxUser)]->id,
                'new_id' => $news[min(0, $maxNews)]->id,
                'content' => 'Bài hát này nghe chill thật sự.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(1, $maxUser)]->id,
                'new_id' => $news[min(0, $maxNews)]->id,
                'content' => 'Nghe đi nghe lại vẫn không chán.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(2, $maxUser)]->id,
                'new_id' => $news[min(1, $maxNews)]->id,
                'content' => 'Lời bài hát rất ý nghĩa.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(3, $maxUser)]->id,
                'new_id' => $news[min(2, $maxNews)]->id,
                'content' => 'Beat quá cuốn luôn.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(4, $maxUser)]->id,
                'new_id' => $news[min(3, $maxNews)]->id,
                'content' => 'Bài này hợp nghe lúc đêm khuya.',
                'status' => false,
            ],

            [
                'user_id' => $users[min(5, $maxUser)]->id,
                'new_id' => $news[min(1, $maxNews)]->id,
                'content' => 'Ca sĩ hát quá cảm xúc.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(6, $maxUser)]->id,
                'new_id' => $news[min(4, $maxNews)]->id,
                'content' => 'Giai điệu gây nghiện thật.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(7, $maxUser)]->id,
                'new_id' => $news[min(2, $maxNews)]->id,
                'content' => 'Nghe xong nhớ người yêu cũ luôn.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(8, $maxUser)]->id,
                'new_id' => $news[min(3, $maxNews)]->id,
                'content' => 'MV đẹp mà nhạc cũng hay.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(9, $maxUser)]->id,
                'new_id' => $news[min(0, $maxNews)]->id,
                'content' => 'Đây chắc chắn là bài yêu thích của mình.',
                'status' => true,
            ],

        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}