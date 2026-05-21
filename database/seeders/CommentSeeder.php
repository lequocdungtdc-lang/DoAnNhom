<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $songs = Song::all();

        if ($users->isEmpty() || $songs->isEmpty()) {
            $this->command->warn('Skipping CommentSeeder: users or songs table is empty.');
            return;
        }

        $maxUser = $users->count() - 1;
        $maxSong = $songs->count() - 1;

        $comments = [

            [
                'user_id' => $users[min(0, $maxUser)]->id,
                'song_id' => $songs[min(0, $maxSong)]->id,
                'content' => 'Bài hát này nghe chill thật sự.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(1, $maxUser)]->id,
                'song_id' => $songs[min(0, $maxSong)]->id,
                'content' => 'Nghe đi nghe lại vẫn không chán.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(2, $maxUser)]->id,
                'song_id' => $songs[min(1, $maxSong)]->id,
                'content' => 'Lời bài hát rất ý nghĩa.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(3, $maxUser)]->id,
                'song_id' => $songs[min(2, $maxSong)]->id,
                'content' => 'Beat quá cuốn luôn.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(4, $maxUser)]->id,
                'song_id' => $songs[min(3, $maxSong)]->id,
                'content' => 'Bài này hợp nghe lúc đêm khuya.',
                'status' => false,
            ],

            [
                'user_id' => $users[min(5, $maxUser)]->id,
                'song_id' => $songs[min(1, $maxSong)]->id,
                'content' => 'Ca sĩ hát quá cảm xúc.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(6, $maxUser)]->id,
                'song_id' => $songs[min(4, $maxSong)]->id,
                'content' => 'Giai điệu gây nghiện thật.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(7, $maxUser)]->id,
                'song_id' => $songs[min(2, $maxSong)]->id,
                'content' => 'Nghe xong nhớ người yêu cũ luôn.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(8, $maxUser)]->id,
                'song_id' => $songs[min(3, $maxSong)]->id,
                'content' => 'MV đẹp mà nhạc cũng hay.',
                'status' => true,
            ],

            [
                'user_id' => $users[min(9, $maxUser)]->id,
                'song_id' => $songs[min(0, $maxSong)]->id,
                'content' => 'Đây chắc chắn là bài yêu thích của mình.',
                'status' => true,
            ],

        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}