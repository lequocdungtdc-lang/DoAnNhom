<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Support\AudioUpload;
use App\Support\ImageUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteSongController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $hasActiveSubscription = $user && $user->activeSubscription ? true : false;

        $songs = $user
            ->likedSongs()
            ->with(['artist', 'category', 'album'])
            ->latest('song_user_likes.created_at')
            ->get()
            ->map(function (Song $song) use ($hasActiveSubscription) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'album' => $song->album?->title,
                    'thumbnail' => ImageUpload::url($song->thumbnail),
                    'audio_url' => $song->is_vip && !$hasActiveSubscription ? null : AudioUpload::url($song->audio_file),
                    'listen_count' => $song->listen_count,
                    'is_liked' => true,
                    'is_vip' => (bool) $song->is_vip,
                    'can_play' => !$song->is_vip || $hasActiveSubscription,
                ];
            })
            ->filter(fn (array $song) => $song['audio_url'] !== null)
            ->values();

        return view('web.favorites.index', [
            'songs' => $songs,
        ]);
    }

    public function toggle(Request $request, Song $song): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        $isLiked = $user->likedSongs()->whereKey($song->id)->exists();

        if ($isLiked) {
            $user->likedSongs()->detach($song->id);

            if ($request->expectsJson()) {
                return response()->json([
                    'liked' => false,
                    'message' => 'Đã bỏ bài hát khỏi danh sách yêu thích.',
                ]);
            }

            return back()->with([
                'status' => 'success',
                'message' => 'Đã bỏ bài hát khỏi danh sách yêu thích.',
            ]);
        }

        $user->likedSongs()->attach($song->id);

        if ($request->expectsJson()) {
            return response()->json([
                'liked' => true,
                'message' => 'Đã thêm bài hát vào danh sách yêu thích.',
            ]);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Đã thêm bài hát vào danh sách yêu thích.',
        ]);
    }
}
