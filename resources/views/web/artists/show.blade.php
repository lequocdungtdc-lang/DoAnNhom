@extends('web.master', ['title' => $artist->name])

@php
    $fallbackCover = 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=600&q=80';
@endphp

@section('content')
    <section class="mt-8 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.08] shadow-2xl shadow-violet-950/30 backdrop-blur-xl">
        <div class="grid gap-6 p-5 md:grid-cols-[220px_minmax(0,1fr)] md:p-8">
            <img src="{{ $artistImage ?? $fallbackCover }}" alt="{{ $artist->name }}" class="aspect-square w-full rounded-[2rem] object-cover shadow-2xl shadow-black/40">

            <div class="flex flex-col justify-center">
                <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Nghệ sĩ</p>
                <h1 class="mt-3 text-4xl font-extrabold leading-tight sm:text-5xl">{{ $artist->name }}</h1>
                <p class="mt-3 text-sm text-violet-100/75">{{ $songs->count() }} bài hát có thể nghe</p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <button type="button" class="play-song rounded-full bg-gradient-to-r from-fuchsia-500 to-violet-500 px-6 py-3 text-sm font-bold shadow-lg shadow-fuchsia-950/40 transition hover:brightness-110" data-index="0" data-can-play="{{ ($featuredSong['can_play'] ?? false) ? '1' : '0' }}">
                        Phát nghệ sĩ
                    </button>
                    @if (!$hasActiveSubscription)
                        <a href="{{ route('plans.index') }}" class="rounded-full border border-yellow-300/30 px-5 py-3 text-sm font-semibold text-yellow-100 transition hover:bg-yellow-400/10">
                            Mở khóa bài VIP
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 rounded-[2rem] border border-white/10 bg-black/20 p-4 backdrop-blur-xl sm:p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Danh sách phát</p>
                <h2 class="mt-2 text-2xl font-bold">Bài hát của {{ $artist->name }}</h2>
            </div>
            <p class="text-sm text-white/50">Click để nghe</p>
        </div>

        <div class="mt-5 space-y-2">
            @forelse ($songs as $index => $song)
                <div class="group flex w-full items-center gap-4 rounded-2xl px-3 py-3 transition hover:bg-white/10">
                    <button type="button" class="play-song flex min-w-0 flex-1 items-center gap-4 text-left {{ !$song['can_play'] ? 'cursor-not-allowed opacity-60' : '' }}" data-index="{{ $index }}" data-can-play="{{ $song['can_play'] ? '1' : '0' }}" @if (!$song['can_play']) onclick="showVipPrompt()" @endif>
                        <span class="w-6 text-center text-sm text-white/40 group-hover:text-fuchsia-200">{{ $index + 1 }}</span>
                        <img src="{{ $song['thumbnail'] ?? $fallbackCover }}" alt="{{ $song['title'] }}" class="h-14 w-14 rounded-xl object-cover">
                        <span class="min-w-0 flex-1">
                            <span class="block truncate font-semibold">
                                {{ $song['title'] }}
                                @if ($song['is_vip'])
                                    <span class="ml-2 rounded-full bg-linear-to-r from-yellow-500 to-amber-500 px-2 py-0.5 text-[10px] font-bold text-black uppercase">VIP</span>
                                @endif
                            </span>
                            <span class="mt-1 block truncate text-sm text-white/55">{{ $song['category'] }}</span>
                        </span>
                        <span class="hidden text-sm text-white/45 sm:block">{{ number_format((int) $song['listen_count']) }} lượt nghe</span>
                        <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-white/60 group-hover:border-fuchsia-300/50 group-hover:text-fuchsia-100">
                            {{ $song['can_play'] ? 'Play' : 'VIP' }}
                        </span>
                    </button>

                    @auth
                        <form action="{{ route('favorites.toggle', $song['id']) }}" method="POST" class="favorite-toggle-form" data-song-id="{{ $song['id'] }}">
                            @csrf
                            <button type="submit"
                                data-favorite-button
                                data-liked-class="flex h-10 w-10 items-center justify-center rounded-full border border-fuchsia-300/40 bg-fuchsia-500/20 text-fuchsia-100 transition hover:bg-fuchsia-500/30 disabled:cursor-not-allowed disabled:opacity-60"
                                data-unliked-class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 text-white/45 transition hover:bg-white/10 hover:text-fuchsia-100 disabled:cursor-not-allowed disabled:opacity-60"
                                class="{{ $song['is_liked'] ? 'flex h-10 w-10 items-center justify-center rounded-full border border-fuchsia-300/40 bg-fuchsia-500/20 text-fuchsia-100 transition hover:bg-fuchsia-500/30 disabled:cursor-not-allowed disabled:opacity-60' : 'flex h-10 w-10 items-center justify-center rounded-full border border-white/10 text-white/45 transition hover:bg-white/10 hover:text-fuchsia-100 disabled:cursor-not-allowed disabled:opacity-60' }}">
                                {{ $song['is_liked'] ? '♥' : '♡' }}
                            </button>
                        </form>
                    @endauth
                </div>
            @empty
                <div class="rounded-3xl border border-dashed border-white/15 p-8 text-center text-white/60">
                    Nghệ sĩ này chưa có bài hát khả dụng.
                </div>
            @endforelse
        </div>
    </section>
@endsection

@section('player')
    <footer class="fixed inset-x-0 bottom-0 z-50 border-t border-white/10 bg-[#120b24]/95 px-4 py-3 shadow-2xl shadow-black/60 backdrop-blur-xl">
        <div class="mx-auto flex max-w-[1500px] flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex min-w-0 items-center gap-3 max-w-[300px] w-full">
                <img id="playerCover" src="{{ $featuredSong['thumbnail'] ?? $fallbackCover }}" alt="Đang phát" class="h-14 w-14 rounded-2xl object-cover">
                <div class="min-w-0">
                    <p id="playerTitle" class="truncate font-semibold">{{ $featuredSong['title'] ?? 'Chưa chọn bài hát' }}</p>
                    <p id="playerArtist" class="truncate text-sm text-white/55">{{ $artist->name }}</p>
                </div>
            </div>

            <div class="flex flex-1 flex-col items-center gap-2 md:max-w-2xl">
                <div class="flex items-center gap-3">
                    <button type="button" id="prevButton" class="rounded-full border border-white/10 px-3 py-2 text-sm text-white/70 transition hover:bg-white/10">Prev</button>
                    <button type="button" id="playButton" class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-lg font-black text-[#170f2f] transition hover:bg-violet-100">▶</button>
                    <button type="button" id="nextButton" class="rounded-full border border-white/10 px-3 py-2 text-sm text-white/70 transition hover:bg-white/10">Next</button>
                </div>
                <div class="flex w-full items-center gap-3 text-xs text-white/45">
                    <span id="currentTime">0:00</span>
                    <input id="seekBar" type="range" min="0" max="100" value="0" class="h-1 w-full accent-fuchsia-400">
                    <span id="duration">0:00</span>
                </div>
            </div>

            <div class="hidden items-center gap-3 md:flex">
                <span class="text-xs text-white/45">Âm lượng</span>
                <input id="volumeBar" type="range" min="0" max="1" step="0.01" value="0.8" class="w-28 accent-fuchsia-400">
            </div>
        </div>
        <audio id="audioPlayer" preload="metadata"></audio>
    </footer>
@endsection

@push('scripts')
    <script>
        const songs = @json($songs);
        const fallbackCover = @json($fallbackCover);
        const audio = document.getElementById('audioPlayer');
        const playButton = document.getElementById('playButton');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        const seekBar = document.getElementById('seekBar');
        const volumeBar = document.getElementById('volumeBar');
        const currentTime = document.getElementById('currentTime');
        const duration = document.getElementById('duration');
        const playerCover = document.getElementById('playerCover');
        const playerTitle = document.getElementById('playerTitle');
        const playerArtist = document.getElementById('playerArtist');
        let currentIndex = 0;
        let isSeeking = false;
        let progressInterval = null;

        function formatTime(seconds) {
            if (!Number.isFinite(seconds)) return '0:00';
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = Math.floor(seconds % 60).toString().padStart(2, '0');
            return `${minutes}:${remainingSeconds}`;
        }

        function showVipPrompt() {
            window.showWebToast('Bài hát VIP. Vui lòng mua gói đăng ký để nghe.', 'error');
        }

        function sendProgress(songId) {
            @auth
            if (!songId) return;
            fetch(`/listening-history/${songId}/progress`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ seconds: 10 })
            }).catch(() => {});
            @endauth
        }

        function loadSong(index, shouldPlay = false) {
            if (!songs.length || !songs[index]) return;

            currentIndex = index;
            const song = songs[currentIndex];

            if (!song.can_play || !song.audio_url) {
                showVipPrompt();
                return;
            }

            audio.src = song.audio_url;
            playerCover.src = song.thumbnail || fallbackCover;
            playerTitle.textContent = song.title;
            playerArtist.textContent = song.artist;
            seekBar.value = 0;
            currentTime.textContent = '0:00';
            duration.textContent = '0:00';

            if (shouldPlay) audio.play();
        }

        function playCurrent() {
            const song = songs[currentIndex];
            if (!song || !song.can_play) {
                showVipPrompt();
                return;
            }

            if (!audio.src) loadSong(currentIndex);
            audio.play();
        }

        document.querySelectorAll('.play-song').forEach((button) => {
            button.addEventListener('click', () => {
                if (button.dataset.canPlay !== '1') {
                    showVipPrompt();
                    return;
                }
                loadSong(Number(button.dataset.index), true);
            });
        });

        playButton.addEventListener('click', () => audio.paused ? playCurrent() : audio.pause());
        prevButton.addEventListener('click', () => songs.length && loadSong((currentIndex - 1 + songs.length) % songs.length, true));
        nextButton.addEventListener('click', () => songs.length && loadSong((currentIndex + 1) % songs.length, true));

        audio.addEventListener('play', () => {
            playButton.textContent = '❚❚';
            @auth
            const song = songs[currentIndex];
            if (song && song.id) {
                fetch(`/listening-history/${song.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                }).catch(() => {});

                clearInterval(progressInterval);
                progressInterval = setInterval(() => sendProgress(song.id), 10000);
            }
            @endauth
        });

        audio.addEventListener('pause', () => {
            playButton.textContent = '▶';
            clearInterval(progressInterval);
            progressInterval = null;
        });

        audio.addEventListener('loadedmetadata', () => duration.textContent = formatTime(audio.duration));
        audio.addEventListener('timeupdate', () => {
            if (isSeeking || !audio.duration) return;
            seekBar.value = (audio.currentTime / audio.duration) * 100;
            currentTime.textContent = formatTime(audio.currentTime);
        });
        audio.addEventListener('ended', () => songs.length && loadSong((currentIndex + 1) % songs.length, true));
        seekBar.addEventListener('input', () => isSeeking = true);
        seekBar.addEventListener('change', () => {
            if (audio.duration) audio.currentTime = (Number(seekBar.value) / 100) * audio.duration;
            isSeeking = false;
        });
        volumeBar.addEventListener('input', () => audio.volume = Number(volumeBar.value));

        audio.volume = Number(volumeBar.value);
        const firstPlayableIndex = songs.findIndex((song) => song.can_play && song.audio_url);
        if (firstPlayableIndex !== -1) loadSong(firstPlayableIndex);
    </script>
@endpush
