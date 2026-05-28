@extends('web.master', ['title' => $podcast->title])

@php
    $fallbackCover = 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=600&q=80';
    $tracks = collect([$currentPodcast])->merge($relatedPodcasts)->values();
@endphp

@section('content')
    <section class="mt-8 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.08] shadow-2xl shadow-violet-950/30 backdrop-blur-xl">
        <div class="grid gap-6 p-5 md:grid-cols-[260px_minmax(0,1fr)] md:p-8">
            <img src="{{ $currentPodcast['thumbnail'] ?? $fallbackCover }}" alt="{{ $podcast->title }}" class="aspect-square w-full rounded-[2rem] object-cover shadow-2xl shadow-black/40">

            <div class="flex flex-col justify-center">
                <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Podcast</p>
                <h1 class="mt-3 text-4xl font-extrabold leading-tight sm:text-5xl">{{ $podcast->title }}</h1>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-violet-100/75">{{ $podcast->description ?: 'Podcast' }}</p>
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <button type="button" class="play-podcast rounded-full bg-gradient-to-r from-fuchsia-500 to-violet-500 px-6 py-3 text-sm font-bold shadow-lg shadow-fuchsia-950/40 transition hover:brightness-110" data-index="0">
                        Phát podcast
                    </button>
                    <span class="rounded-full border border-white/10 px-4 py-3 text-sm text-white/70">{{ number_format((int) $currentPodcast['listen_count']) }} lượt nghe</span>
                </div>
            </div>
        </div>
    </section>

    @if ($relatedPodcasts->isNotEmpty())
        <section class="mt-8 rounded-[2rem] border border-white/10 bg-black/20 p-5 backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Nghe tiếp</p>
                    <h2 class="mt-2 text-2xl font-bold">Podcast liên quan</h2>
                </div>
                <a href="{{ route('podcasts.index') }}" class="text-sm text-white/60 transition hover:text-white">Xem tất cả</a>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($relatedPodcasts as $index => $item)
                    <article class="group flex gap-4 rounded-2xl border border-white/10 bg-white/[0.05] p-4 transition hover:bg-white/10">
                        <img src="{{ $item['thumbnail'] ?? $fallbackCover }}" alt="{{ $item['title'] }}" class="h-20 w-20 rounded-2xl object-cover">
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('podcasts.show', $item['id']) }}" class="line-clamp-1 font-semibold text-white hover:text-fuchsia-100">{{ $item['title'] }}</a>
                            <p class="mt-1 line-clamp-2 text-sm text-white/55">{{ $item['description'] ?: 'Podcast' }}</p>
                            <button type="button" class="play-podcast mt-3 rounded-full border border-white/10 px-4 py-2 text-xs font-semibold text-white/70 transition group-hover:border-fuchsia-300/50 group-hover:text-fuchsia-100" data-index="{{ $index + 1 }}">
                                Phát
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@section('player')
    <footer class="fixed inset-x-0 bottom-0 z-50 border-t border-white/10 bg-[#120b24]/95 px-4 py-3 shadow-2xl shadow-black/60 backdrop-blur-xl">
        <div class="mx-auto flex max-w-[1500px] flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex min-w-0 items-center gap-3 max-w-[300px] w-full">
                <img id="playerCover" src="{{ $currentPodcast['thumbnail'] ?? $fallbackCover }}" alt="Đang phát" class="h-14 w-14 rounded-2xl object-cover">
                <div class="min-w-0">
                    <p id="playerTitle" class="truncate font-semibold">{{ $podcast->title }}</p>
                    <p class="truncate text-sm text-white/55">Podcast</p>
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
        const podcasts = @json($tracks);
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
        let currentIndex = 0;
        let isSeeking = false;

        function formatTime(seconds) {
            if (!Number.isFinite(seconds)) return '0:00';
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = Math.floor(seconds % 60).toString().padStart(2, '0');
            return `${minutes}:${remainingSeconds}`;
        }

        function loadPodcast(index, shouldPlay = false) {
            if (!podcasts.length || !podcasts[index]) return;
            currentIndex = index;
            const podcast = podcasts[currentIndex];
            audio.src = podcast.audio_url;
            playerCover.src = podcast.thumbnail || fallbackCover;
            playerTitle.textContent = podcast.title;
            seekBar.value = 0;
            currentTime.textContent = '0:00';
            duration.textContent = '0:00';
            if (shouldPlay) audio.play();
        }

        document.querySelectorAll('.play-podcast').forEach((button) => {
            button.addEventListener('click', () => loadPodcast(Number(button.dataset.index), true));
        });

        playButton.addEventListener('click', () => {
            if (!audio.src) loadPodcast(currentIndex);
            audio.paused ? audio.play() : audio.pause();
        });
        prevButton.addEventListener('click', () => podcasts.length && loadPodcast((currentIndex - 1 + podcasts.length) % podcasts.length, true));
        nextButton.addEventListener('click', () => podcasts.length && loadPodcast((currentIndex + 1) % podcasts.length, true));
        audio.addEventListener('play', () => playButton.textContent = '❚❚');
        audio.addEventListener('pause', () => playButton.textContent = '▶');
        audio.addEventListener('loadedmetadata', () => duration.textContent = formatTime(audio.duration));
        audio.addEventListener('timeupdate', () => {
            if (isSeeking || !audio.duration) return;
            seekBar.value = (audio.currentTime / audio.duration) * 100;
            currentTime.textContent = formatTime(audio.currentTime);
        });
        audio.addEventListener('ended', () => podcasts.length && loadPodcast((currentIndex + 1) % podcasts.length, true));
        seekBar.addEventListener('input', () => isSeeking = true);
        seekBar.addEventListener('change', () => {
            if (audio.duration) audio.currentTime = (Number(seekBar.value) / 100) * audio.duration;
            isSeeking = false;
        });
        volumeBar.addEventListener('input', () => audio.volume = Number(volumeBar.value));

        audio.volume = Number(volumeBar.value);
        loadPodcast(0);
    </script>
@endpush
