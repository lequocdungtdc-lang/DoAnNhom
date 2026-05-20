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

        $comments = [

            [
                'user_id' => $users[0]->id,
                'song_id' => $songs[0]->id,
                'content' => 'Bài hát này nghe chill thật sự.',
                'status' => true,
            ],

            [
                'user_id' => $users[1]->id,
                'song_id' => $songs[0]->id,
                'content' => 'Nghe đi nghe lại vẫn không chán.',
                'status' => true,
            ],

            [
                'user_id' => $users[2]->id,
                'song_id' => $songs[1]->id,
                'content' => 'Lời bài hát rất ý nghĩa.',
                'status' => true,
            ],

            [
                'user_id' => $users[3]->id,
                'song_id' => $songs[2]->id,
                'content' => 'Beat quá cuốn luôn.',
                'status' => true,
            ],

            [
                'user_id' => $users[4]->id,
                'song_id' => $songs[3]->id,
                'content' => 'Bài này hợp nghe lúc đêm khuya.',
                'status' => false,
            ],

            [
                'user_id' => $users[5]->id,
                'song_id' => $songs[1]->id,
                'content' => 'Ca sĩ hát quá cảm xúc.',
                'status' => true,
            ],

            [
                'user_id' => $users[6]->id,
                'song_id' => $songs[4]->id,
                'content' => 'Giai điệu gây nghiện thật.',
                'status' => true,
            ],

            [
                'user_id' => $users[7]->id,
                'song_id' => $songs[2]->id,
                'content' => 'Nghe xong nhớ người yêu cũ luôn.',
                'status' => true,
            ],

            [
                'user_id' => $users[8]->id,
                'song_id' => $songs[3]->id,
                'content' => 'MV đẹp mà nhạc cũng hay.',
                'status' => true,
            ],

            [
                'user_id' => $users[9]->id,
                'song_id' => $songs[0]->id,
                'content' => 'Đây chắc chắn là bài yêu thích của mình.',
                'status' => true,
            ],

        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}