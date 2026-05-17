<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Categories;
use App\Models\Song;
use App\Support\AudioUpload;
use App\Support\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim($request->input('q'));
        $likedSongIds = auth()->check()
            ? auth()->user()->likedSongs()->pluck('songs.id')->all()
            : [];

        $songsQuery = Song::with(['artist', 'category', 'album'])
            ->where('status', true);

        // Full-text search: title, artist name, album title, category name
        if ($query) {
            $songsQuery->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhereHas('artist', function ($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('album', function ($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    });
            });
        } else {
            $songsQuery->latest();
        }

        $songs = $songsQuery->get()
            ->map(function (Song $song) use ($likedSongIds) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'album' => $song->album?->title ?? null,
                    'thumbnail' => ImageUpload::url($song->thumbnail),
                    'audio_url' => AudioUpload::url($song->audio_file),
                    'listen_count' => $song->listen_count,
                    'is_liked' => in_array($song->id, $likedSongIds, true),
                ];
            })
            ->filter(fn (array $song) => $song['audio_url'] !== null)
            ->values();

        // Search artists, albums, categories for result sections
        $searchArtists = [];
        $searchAlbums = [];
        $searchCategories = [];

        if ($query) {
            $searchArtists = Artist::where('name', 'LIKE', "%{$query}%")
                ->where('status', true)
                ->limit(5)
                ->get()
                ->map(fn ($a) => [
                    'id' => $a->id,
                    'name' => $a->name,
                    'image' => ImageUpload::url($a->image),
                    'type' => 'artist',
                ]);

            $searchAlbums = Album::where('title', 'LIKE', "%{$query}%")
                ->where('status', true)
                ->limit(5)
                ->get()
                ->map(fn ($a) => [
                    'id' => $a->id,
                    'title' => $a->title,
                    'cover_image' => ImageUpload::url($a->cover_image),
                    'artist_name' => $a->artist_name,
                    'type' => 'album',
                ]);

            $searchCategories = Categories::where('name', 'LIKE', "%{$query}%")
                ->where('status', true)
                ->limit(5)
                ->get()
                ->map(fn ($c) => [
                    'id' => $c->id,
                    'name' => $c->name,
                    'type' => 'category',
                ]);
        }

        return view('web.home.index', [
            'songs' => $songs,
            'featuredSong' => $songs->first(),
            'topSongs' => $songs->sortByDesc('listen_count')->take(5)->values(),
            'searchQuery' => $query,
            'searchArtists' => $searchArtists,
            'searchAlbums' => $searchAlbums,
            'searchCategories' => $searchCategories,
        ]);
    }

    public function rankings(): View
    {
        $likedSongIds = auth()->check()
            ? auth()->user()->likedSongs()->pluck('songs.id')->all()
            : [];

        $topSongs = Song::with(['artist', 'category', 'album'])
            ->where('status', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderByDesc('listen_count')
            ->limit(50)
            ->get()
            ->map(function (Song $song) use ($likedSongIds) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'thumbnail' => ImageUpload::url($song->thumbnail),
                    'audio_url' => AudioUpload::url($song->audio_file),
                    'listen_count' => $song->listen_count,
                    'is_liked' => in_array($song->id, $likedSongIds, true),
                ];
            })
            ->filter(fn (array $song) => $song['audio_url'] !== null)
            ->values();

        $topArtists = Artist::withCount(['songs as listen_count' => function ($query) {
                $query->selectRaw('sum(songs.listen_count)');
            }])
            ->where('status', true)
            ->orderByDesc('listen_count')
            ->limit(10)
            ->get()
            ->map(fn ($a) => [
                'id' => $a->id,
                'name' => $a->name,
                'image' => ImageUpload::url($a->image),
                'listen_count' => $a->listen_count ?? 0,
            ]);

        return view('web.rankings.index', [
            'topSongs' => $topSongs,
            'topArtists' => $topArtists,
            'featuredSong' => $topSongs->first(),
        ]);
    }
}