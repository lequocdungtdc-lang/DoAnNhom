<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use App\Support\AudioUpload;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    public function index(Request $request): View
    {
        $playlists = $request->user()
            ->playlists()
            ->withCount('songs')
            ->latest()
            ->paginate(12);

        return view('web.playlists.index', [
            'playlists' => $playlists,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'Vui lòng nhập tên danh sách phát.',
            'name.max' => 'Tên danh sách phát không được vượt quá 255 ký tự.',
        ]);

        $playlist = $request->user()->playlists()->create($validated);

        return redirect()->route('playlists.show', $playlist)->with([
            'status' => 'success',
            'message' => 'Đã tạo danh sách phát.',
        ]);
    }

    public function show(Request $request, Playlist $playlist): View
    {
        $this->authorizePlaylist($request, $playlist);

        $user = $request->user();
        $hasActiveSubscription = $user && $user->activeSubscription ? true : false;
        $likedSongIds = $user->likedSongs()->pluck('songs.id')->all();

        $songs = $playlist->songs()
            ->with(['artist', 'category', 'album'])
            ->latest('playlist_song.created_at')
            ->get()
            ->map(function (Song $song) use ($likedSongIds, $hasActiveSubscription) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'album' => $song->album?->title,
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

        return view('web.playlists.show', [
            'playlist' => $playlist,
            'songs' => $songs,
            'featuredSong' => $songs->first(),
            'hasActiveSubscription' => $hasActiveSubscription,
        ]);
    }

    public function addSong(Request $request, Song $song): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'playlist_id' => ['required', 'integer', 'exists:playlists,id'],
        ], [
            'playlist_id.required' => 'Vui lòng chọn danh sách phát.',
        ]);

        $playlist = $request->user()
            ->playlists()
            ->whereKey($validated['playlist_id'])
            ->firstOrFail();

        $alreadyExists = $playlist->songs()->where('songs.id', $song->id)->exists();
        $playlist->songs()->syncWithoutDetaching([$song->id]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $alreadyExists ? 'Bài hát đã có trong danh sách phát.' : 'Đã thêm bài hát vào danh sách phát.',
                'already_exists' => $alreadyExists,
                'playlist_id' => $playlist->id,
                'song_id' => $song->id,
            ]);
        }

        return back()->with([
            'status' => 'success',
            'message' => 'Đã thêm bài hát vào danh sách phát.',
        ]);
    }

    public function removeSong(Request $request, Playlist $playlist, Song $song): RedirectResponse
    {
        $this->authorizePlaylist($request, $playlist);

        $playlist->songs()->detach($song->id);

        return back()->with([
            'status' => 'success',
            'message' => 'Đã xóa bài hát khỏi danh sách phát.',
        ]);
    }

    public function delete(Request $request, Playlist $playlist): RedirectResponse
    {
        $this->authorizePlaylist($request, $playlist);
        $playlist->delete();

        return redirect()->route('playlists.index')->with([
            'status' => 'success',
            'message' => 'Đã xóa danh sách phát.',
        ]);
    }

    private function authorizePlaylist(Request $request, Playlist $playlist): void
    {
        abort_unless($playlist->user_id === $request->user()->id, 404);
    }
}
