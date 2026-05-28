@auth
    @if (($userPlaylists ?? collect())->isNotEmpty())
        <form action="{{ route('playlists.songs.add', $song['id']) }}" method="POST" class="flex items-center gap-2">
            @csrf
            <select name="playlist_id" class="h-10 max-w-36 rounded-full border border-white/10 bg-[#180f2f] px-3 text-xs text-white outline-none focus:border-fuchsia-300">
                <option value="">Playlist</option>
                @foreach ($userPlaylists as $playlistOption)
                    <option value="{{ $playlistOption->id }}">{{ $playlistOption->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="h-10 rounded-full border border-white/10 px-3 text-xs font-semibold text-white/60 transition hover:border-fuchsia-300/50 hover:text-fuchsia-100">
                Thêm
            </button>
        </form>
    @else
        <a href="{{ route('playlists.index') }}" class="rounded-full border border-white/10 px-3 py-2 text-xs font-semibold text-white/60 transition hover:border-fuchsia-300/50 hover:text-fuchsia-100">
            Tạo playlist
        </a>
    @endif
@endauth
