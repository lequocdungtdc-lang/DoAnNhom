<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Support\AudioUpload;
use App\Support\ImageUpload;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Trang chủ - Hiển thị trang mặc định Laravel
     */
    public function index(): View
    {
        $likedSongIds = auth()->check()
            ? auth()->user()->likedSongs()->pluck('songs.id')->all()
            : [];


        $songs = Song::with(['artist', 'category', 'album'])
            ->where('status', true)
            ->latest()
            ->get()
            ->map(function (Song $song) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'album' => $song->album?->title ?? null,
                    'thumbnail' => ImageUpload::url($song->thumbnail),
                    'audio_url' => AudioUpload::url($song->audio_file),
                    'listen_count' => $song->listen_count,
                    'is_liked' => !empty($likedSongIds) ? in_array($song->id, $likedSongIds, true) : false,
                ];
            })
            ->filter(fn (array $song) => $song['audio_url'] !== null)
            ->values();

        return view('web.home.index', [
            'songs' => $songs,
            'featuredSong' => $songs->first(),
            'topSongs' => $songs->sortByDesc('listen_count')->take(5)->values(),
        ]);
    }
}