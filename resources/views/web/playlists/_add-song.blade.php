@auth
    @if (($userPlaylists ?? collect())->isNotEmpty())
        <div class="add-to-playlist-wrapper flex items-center gap-2" data-song-id="{{ $song['id'] }}">
            <select name="playlist_id" class="playlist-select h-10 max-w-36 rounded-full border border-white/10 bg-[#180f2f] px-3 text-xs text-white outline-none focus:border-fuchsia-300">
                <option value="">Playlist</option>
                @foreach ($userPlaylists as $playlistOption)
                    @php
                        $isInPlaylist = $playlistOption->songs->contains('id', $song['id']);
                    @endphp
                    <option value="{{ $playlistOption->id }}" @if($isInPlaylist) data-added="1" @endif>
                        {{ $playlistOption->name }}{{ $isInPlaylist ? ' ✓' : '' }}
                    </option>
                @endforeach
            </select>
            <button type="button" class="add-to-playlist-btn h-10 rounded-full border border-white/10 px-3 text-xs font-semibold text-white/60 transition hover:border-fuchsia-300/50 hover:text-fuchsia-100">
                Thêm
            </button>
        </div>
    @else
        <a href="{{ route('playlists.index') }}" class="rounded-full border border-white/10 px-3 py-2 text-xs font-semibold text-white/60 transition hover:border-fuchsia-300/50 hover:text-fuchsia-100">
            Tạo playlist
        </a>
    @endif
@endauth
