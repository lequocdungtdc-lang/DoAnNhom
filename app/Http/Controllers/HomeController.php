<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Categories;
use App\Models\Podcast;
use App\Models\Song;
use App\Models\Ad;
use App\Support\AudioUpload;
use App\Support\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim($request->input('q'));
        $user = auth()->user();
        $hasActiveSubscription = $user && $user->activeSubscription ? true : false;
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
            ->map(function (Song $song) use ($likedSongIds, $hasActiveSubscription) {
                return [
                    'id' => $song->id,
                    'type' => 'song',
                    'artist_id' => $song->artist_id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'subtitle' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'album' => $song->album?->title ?? null,
                    'thumbnail' => ImageUpload::url($song->thumbnail),
                    'audio_url' => AudioUpload::url($song->audio_file),
                    'listen_count' => $song->listen_count,
                    'is_liked' => in_array($song->id, $likedSongIds, true),
                    'is_vip' => (bool) $song->is_vip,
                    'can_play' => !$song->is_vip || $hasActiveSubscription,
                ];
            })
                ->filter(fn (array $song) => $song['audio_url'] !== null)
                ->values();

        $podcasts = Podcast::where('status', true)
            ->latest()
            ->get()
            ->map(fn (Podcast $podcast) => [
                'id' => $podcast->id,
                'type' => 'podcast',
                'title' => $podcast->title,
                'artist' => 'Podcast',
                'subtitle' => 'Podcast',
                'description' => $podcast->description,
                'thumbnail' => ImageUpload::url($podcast->thumbnail),
                'audio_url' => AudioUpload::url($podcast->audio_file),
                'listen_count' => $podcast->views ?? 0,
                'duration' => $podcast->duration,
                'can_play' => true,
            ])
            ->filter(fn (array $podcast) => $podcast['audio_url'] !== null)
            ->values();

        $artists = Artist::withCount(['songs' => function ($query) {
                $query->where('status', true);
            }])
            ->where('status', true)
            ->orderBy('name')
            ->limit(12)
            ->get()
            ->map(fn (Artist $artist) => [
                'id' => $artist->id,
                'name' => $artist->name,
                'image' => ImageUpload::url($artist->image),
                'songs_count' => $artist->songs_count,
            ]);

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
                    'songs_count' => $a->songs()->where('status', true)->count(),
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

        $activeAds = $hasActiveSubscription ? collect() : Ad::where('is_active', true)->get();

        return view('web.home.index', [
            'songs' => $songs,
            'podcasts' => $podcasts,
            'artists' => $artists,
            'userPlaylists' => $user ? $user->playlists()->with('songs')->orderBy('name')->get() : collect(),
            'featuredSong' => $songs->first(),
            'topSongs' => $songs->sortByDesc('listen_count')->take(5)->values(),
            'searchQuery' => $query,
            'searchArtists' => $searchArtists,
            'searchAlbums' => $searchAlbums,
            'searchCategories' => $searchCategories,
            'activeAds' => $activeAds,
            'hasActiveSubscription' => $hasActiveSubscription,
        ]);
    }

    public function rankings(): View
    {
        $user = auth()->user();
        $hasActiveSubscription = $user && $user->activeSubscription ? true : false;
        $likedSongIds = auth()->check()
            ? auth()->user()->likedSongs()->pluck('songs.id')->all()
            : [];

        $topSongs = Song::with(['artist', 'category', 'album'])
            ->where('status', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderByDesc('listen_count')
            ->limit(50)
            ->get()
            ->map(function (Song $song) use ($likedSongIds, $hasActiveSubscription) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'thumbnail' => ImageUpload::url($song->thumbnail),
                    'audio_url' => AudioUpload::url($song->audio_file),
                    'listen_count' => $song->listen_count,
                    'is_liked' => in_array($song->id, $likedSongIds, true),
                    'is_vip' => (bool) $song->is_vip,
                    'can_play' => !$song->is_vip || $hasActiveSubscription,
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

    public function artistShow(Artist $artist): View
    {
        abort_unless($artist->status, 404);

        $user = auth()->user();
        $hasActiveSubscription = $user && $user->activeSubscription ? true : false;
        $likedSongIds = auth()->check()
            ? auth()->user()->likedSongs()->pluck('songs.id')->all()
            : [];

        $songs = Song::with(['artist', 'category', 'album'])
            ->where('status', true)
            ->where('artist_id', $artist->id)
            ->latest()
            ->get()
            ->map(function (Song $song) use ($likedSongIds, $hasActiveSubscription) {
                return [
                    'id' => $song->id,
                    'type' => 'song',
                    'artist_id' => $song->artist_id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'subtitle' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'album' => $song->album?->title ?? null,
                    'thumbnail' => ImageUpload::url($song->thumbnail),
                    'audio_url' => AudioUpload::url($song->audio_file),
                    'listen_count' => $song->listen_count,
                    'is_liked' => in_array($song->id, $likedSongIds, true),
                    'is_vip' => (bool) $song->is_vip,
                    'can_play' => ! $song->is_vip || $hasActiveSubscription,
                ];
            })
            ->filter(fn (array $song) => $song['audio_url'] !== null)
            ->values();

        return view('web.artists.show', [
            'artist' => $artist,
            'artistImage' => ImageUpload::url($artist->image),
            'songs' => $songs,
            'userPlaylists' => $user ? $user->playlists()->with('songs')->orderBy('name')->get() : collect(),
            'featuredSong' => $songs->first(),
            'hasActiveSubscription' => $hasActiveSubscription,
        ]);
    }

    public function artistsIndex(): View
    {
        $artists = Artist::withCount(['songs' => function ($query) {
                $query->where('status', true);
            }])
            ->where('status', true)
            ->orderBy('name')
            ->paginate(24)
            ->through(fn (Artist $artist) => [
                'id' => $artist->id,
                'name' => $artist->name,
                'image' => ImageUpload::url($artist->image),
                'songs_count' => $artist->songs_count,
            ]);

        return view('web.artists.index', [
            'artists' => $artists,
        ]);
    }

    public function podcastsIndex(): View
    {
        $podcasts = Podcast::where('status', true)
            ->latest()
            ->get()
            ->map(fn (Podcast $podcast) => [
                'id' => $podcast->id,
                'type' => 'podcast',
                'title' => $podcast->title,
                'artist' => 'Podcast',
                'subtitle' => 'Podcast',
                'description' => $podcast->description,
                'thumbnail' => ImageUpload::url($podcast->thumbnail),
                'audio_url' => AudioUpload::url($podcast->audio_file),
                'listen_count' => $podcast->views ?? 0,
                'duration' => $podcast->duration,
                'can_play' => true,
            ])
            ->filter(fn (array $podcast) => $podcast['audio_url'] !== null)
            ->values();

        return view('web.podcasts.index', [
            'podcasts' => $podcasts,
            'featuredPodcast' => $podcasts->first(),
        ]);
    }

    public function podcastShow(Podcast $podcast): View
    {
        abort_unless($podcast->status, 404);

        $podcast->increment('views');

        $currentPodcast = [
            'id' => $podcast->id,
            'type' => 'podcast',
            'title' => $podcast->title,
            'artist' => 'Podcast',
            'subtitle' => 'Podcast',
            'description' => $podcast->description,
            'thumbnail' => ImageUpload::url($podcast->thumbnail),
            'audio_url' => AudioUpload::url($podcast->audio_file),
            'listen_count' => $podcast->views ?? 0,
            'duration' => $podcast->duration,
            'can_play' => true,
        ];

        $relatedPodcasts = Podcast::where('status', true)
            ->whereKeyNot($podcast->id)
            ->latest()
            ->limit(6)
            ->get()
            ->map(fn (Podcast $item) => [
                'id' => $item->id,
                'type' => 'podcast',
                'title' => $item->title,
                'artist' => 'Podcast',
                'subtitle' => 'Podcast',
                'description' => $item->description,
                'thumbnail' => ImageUpload::url($item->thumbnail),
                'audio_url' => AudioUpload::url($item->audio_file),
                'listen_count' => $item->views ?? 0,
                'duration' => $item->duration,
                'can_play' => true,
            ])
            ->filter(fn (array $item) => $item['audio_url'] !== null)
            ->values();

        return view('web.podcasts.show', [
            'podcast' => $podcast,
            'currentPodcast' => $currentPodcast,
            'relatedPodcasts' => $relatedPodcasts,
        ]);
    }
}
