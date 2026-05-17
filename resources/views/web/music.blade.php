<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Âm nhạc trực tuyến</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/web.css', 'resources/css/style.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#170f2f] text-white antialiased">
    @php
        $fallbackCover = 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=600&q=80';
    @endphp

    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(138,43,226,0.38),_transparent_30%),radial-gradient(circle_at_top_right,_rgba(236,72,153,0.25),_transparent_25%),linear-gradient(180deg,_#1b1239_0%,_#100b22_55%,_#090613_100%)] pb-32">
        <div class="mx-auto grid min-h-screen max-w-[1500px] grid-cols-1 lg:grid-cols-[260px_minmax(0,1fr)]">
            <aside class="hidden border-r border-white/10 bg-black/15 px-5 py-6 backdrop-blur-xl lg:block">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-500 to-violet-500 text-xl font-black">M</div>
                    <div>
                        <p class="text-lg font-bold tracking-tight">Music Hub</p>
                        <p class="text-xs text-violet-200/70">Nghe nhạc online</p>
                    </div>
                </div>

                <nav class="mt-8 space-y-2 text-sm font-medium">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-2xl bg-white/10 px-4 py-3 text-white shadow-lg shadow-violet-950/30">
                        <span>●</span>
                        Khám phá
                    </a>
                    <span class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/55">
                        <span>○</span>
                        BXH nhạc mới
                    </span>
                    <span class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/55">
                        <span>○</span>
                        Radio
                    </span>
                    <span class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/55">
                        <span>○</span>
                        Thư viện
                    </span>
                </nav>

                <div class="mt-8 rounded-3xl border border-white/10 bg-white/[0.06] p-4">
                    <p class="text-sm font-semibold">Gợi ý hôm nay</p>
                    <p class="mt-2 text-xs leading-5 text-violet-100/70">Chọn một bài hát bất kỳ để phát bằng player phía dưới.</p>
                </div>
            </aside>

            <main class="min-w-0 px-4 py-5 sm:px-6 lg:px-8">
                <header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-3">
                        <button type="button" class="rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white/80 lg:hidden">Music Hub</button>
                        <div class="relative w-full max-w-xl md:w-[420px]">
                            <input type="text" disabled value="Tìm kiếm bài hát, nghệ sĩ, album"
                                class="w-full rounded-full border border-white/10 bg-white/10 px-5 py-3 text-sm text-white/50 outline-none backdrop-blur">
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'dashboard') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm text-white/80 transition hover:bg-white/10">Tài khoản</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm text-white/80 transition hover:bg-white/10">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#170f2f] transition hover:bg-violet-100">Đăng ký</a>
                        @endauth
                    </div>
                </header>

                @if ($featuredSong)
                    <section class="mt-8 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.08] shadow-2xl shadow-violet-950/30 backdrop-blur-xl">
                        <div class="grid gap-6 p-5 md:grid-cols-[minmax(0,1fr)_320px] md:p-8">
                            <div class="flex flex-col justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Playlist nổi bật</p>
                                    <h1 class="mt-4 max-w-3xl text-4xl font-extrabold leading-tight sm:text-5xl">
                                        Chạm vào bài hát và phát nhạc ngay
                                    </h1>
                                    <p class="mt-4 max-w-2xl text-sm leading-6 text-violet-100/75">
                                        Giao diện nghe nhạc lấy cảm hứng từ trải nghiệm khám phá và player cố định của Zing MP3, tập trung trước vào phát nhạc.
                                    </p>
                                </div>

                                <div class="mt-8 flex flex-wrap items-center gap-3">
                                    <button type="button"
                                        class="play-song rounded-full bg-gradient-to-r from-fuchsia-500 to-violet-500 px-6 py-3 text-sm font-bold shadow-lg shadow-fuchsia-950/40 transition hover:brightness-110"
                                        data-index="0">
                                        Phát ngay
                                    </button>
                                    <span class="rounded-full border border-white/10 px-4 py-3 text-sm text-white/70">
                                        {{ $songs->count() }} bài hát khả dụng
                                    </span>
                                </div>
                            </div>

                            <div class="relative">
                                <div class="absolute inset-8 rounded-full bg-fuchsia-500/30 blur-3xl"></div>
                                <img src="{{ $featuredSong['thumbnail'] ?? $fallbackCover }}" alt="{{ $featuredSong['title'] }}"
                                    class="relative aspect-square w-full rounded-[2rem] object-cover shadow-2xl shadow-black/40">
                            </div>
                        </div>
                    </section>
                @endif

                <section class="mt-8 grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
                    <div class="rounded-[2rem] border border-white/10 bg-black/20 p-4 backdrop-blur-xl sm:p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Bài hát</p>
                                <h2 class="mt-2 text-2xl font-bold">Danh sách phát</h2>
                            </div>
                            <p class="text-sm text-white/50">Click để nghe</p>
                        </div>

                        <div class="mt-5 space-y-2">
                            @forelse ($songs as $index => $song)
                                <button type="button"
                                    class="play-song group flex w-full items-center gap-4 rounded-2xl px-3 py-3 text-left transition hover:bg-white/10"
                                    data-index="{{ $index }}">
                                    <span class="w-6 text-center text-sm text-white/40 group-hover:text-fuchsia-200">{{ $index + 1 }}</span>
                                    <img src="{{ $song['thumbnail'] ?? $fallbackCover }}" alt="{{ $song['title'] }}" class="h-14 w-14 rounded-xl object-cover">
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate font-semibold">{{ $song['title'] }}</span>
                                        <span class="mt-1 block truncate text-sm text-white/55">{{ $song['artist'] }} • {{ $song['category'] }}</span>
                                    </span>
                                    <span class="hidden text-sm text-white/45 sm:block">{{ number_format((int) $song['listen_count']) }} lượt nghe</span>
                                    <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-white/60 group-hover:border-fuchsia-300/50 group-hover:text-fuchsia-100">Play</span>
                                </button>
                            @empty
                                <div class="rounded-3xl border border-dashed border-white/15 p-8 text-center text-white/60">
                                    Chưa có bài hát có file âm thanh để phát. Hãy thêm bài hát trong trang admin trước.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <aside class="rounded-[2rem] border border-white/10 bg-white/[0.07] p-5 backdrop-blur-xl">
                        <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">BXH</p>
                        <h2 class="mt-2 text-2xl font-bold">Nghe nhiều</h2>

                        <div class="mt-5 space-y-3">
                            @forelse ($topSongs as $index => $song)
                                <button type="button" class="play-song flex w-full items-center gap-3 rounded-2xl bg-white/[0.05] p-3 text-left transition hover:bg-white/10" data-index="{{ $songs->search(fn ($item) => $item['id'] === $song['id']) }}">
                                    <span class="text-xl font-black text-fuchsia-300">{{ $index + 1 }}</span>
                                    <img src="{{ $song['thumbnail'] ?? $fallbackCover }}" alt="{{ $song['title'] }}" class="h-12 w-12 rounded-xl object-cover">
                                    <span class="min-w-0">
                                        <span class="block truncate text-sm font-semibold">{{ $song['title'] }}</span>
                                        <span class="mt-1 block truncate text-xs text-white/50">{{ $song['artist'] }}</span>
                                    </span>
                                </button>
                            @empty
                                <p class="text-sm text-white/55">Chưa có dữ liệu xếp hạng.</p>
                            @endforelse
                        </div>
                    </aside>
                </section>
            </main>
        </div>
    </div>

    <footer class="fixed inset-x-0 bottom-0 z-50 border-t border-white/10 bg-[#120b24]/95 px-4 py-3 shadow-2xl shadow-black/60 backdrop-blur-xl">
        <div class="mx-auto flex max-w-[1500px] flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex min-w-0 items-center gap-3">
                <img id="playerCover" src="{{ $featuredSong['thumbnail'] ?? $fallbackCover }}" alt="Đang phát" class="h-14 w-14 rounded-2xl object-cover">
                <div class="min-w-0">
                    <p id="playerTitle" class="truncate font-semibold">{{ $featuredSong['title'] ?? 'Chưa chọn bài hát' }}</p>
                    <p id="playerArtist" class="truncate text-sm text-white/55">{{ $featuredSong['artist'] ?? 'Chọn một bài trong danh sách' }}</p>
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

        function formatTime(seconds) {
            if (!Number.isFinite(seconds)) {
                return '0:00';
            }

            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = Math.floor(seconds % 60).toString().padStart(2, '0');
            return `${minutes}:${remainingSeconds}`;
        }

        function loadSong(index, shouldPlay = false) {
            if (!songs.length || !songs[index]) {
                return;
            }

            currentIndex = index;
            const song = songs[currentIndex];
            audio.src = song.audio_url;
            playerCover.src = song.thumbnail || fallbackCover;
            playerTitle.textContent = song.title;
            playerArtist.textContent = song.artist;
            seekBar.value = 0;
            currentTime.textContent = '0:00';
            duration.textContent = '0:00';

            if (shouldPlay) {
                audio.play();
            }
        }

        function playCurrent() {
            if (!audio.src) {
                loadSong(currentIndex);
            }

            audio.play();
        }

        function pauseCurrent() {
            audio.pause();
        }

        document.querySelectorAll('.play-song').forEach((button) => {
            button.addEventListener('click', () => {
                loadSong(Number(button.dataset.index), true);
            });
        });

        playButton.addEventListener('click', () => {
            if (audio.paused) {
                playCurrent();
            } else {
                pauseCurrent();
            }
        });

        prevButton.addEventListener('click', () => {
            if (!songs.length) {
                return;
            }

            const nextIndex = (currentIndex - 1 + songs.length) % songs.length;
            loadSong(nextIndex, true);
        });

        nextButton.addEventListener('click', () => {
            if (!songs.length) {
                return;
            }

            const nextIndex = (currentIndex + 1) % songs.length;
            loadSong(nextIndex, true);
        });

        audio.addEventListener('play', () => {
            playButton.textContent = '❚❚';
        });

        audio.addEventListener('pause', () => {
            playButton.textContent = '▶';
        });

        audio.addEventListener('loadedmetadata', () => {
            duration.textContent = formatTime(audio.duration);
        });

        audio.addEventListener('timeupdate', () => {
            if (isSeeking || !audio.duration) {
                return;
            }

            seekBar.value = (audio.currentTime / audio.duration) * 100;
            currentTime.textContent = formatTime(audio.currentTime);
        });

        audio.addEventListener('ended', () => {
            if (!songs.length) {
                return;
            }

            const nextIndex = (currentIndex + 1) % songs.length;
            loadSong(nextIndex, true);
        });

        seekBar.addEventListener('input', () => {
            isSeeking = true;
        });

        seekBar.addEventListener('change', () => {
            if (audio.duration) {
                audio.currentTime = (Number(seekBar.value) / 100) * audio.duration;
            }

            isSeeking = false;
        });

        volumeBar.addEventListener('input', () => {
            audio.volume = Number(volumeBar.value);
        });

        audio.volume = Number(volumeBar.value);
        loadSong(0);
    </script>
</body>
</html>
