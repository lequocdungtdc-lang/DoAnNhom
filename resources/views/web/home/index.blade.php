@extends('web.master', ['title' => 'Khám phá âm nhạc'])

@php
    $fallbackCover = 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=600&q=80';
    $songCount = $songs->count();
    $initialTrack = $featuredSong ?? $podcasts->first();
@endphp

@section('content')
    @if ($searchQuery)
        <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 shadow-2xl shadow-violet-950/30 backdrop-blur-xl sm:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Kết quả tìm kiếm</p>
            <h1 class="mt-3 text-3xl font-extrabold leading-tight">Tìm thấy cho "<span class="text-fuchsia-200">{{ $searchQuery }}</span>"</h1>
        </section>

        @if ($searchArtists->isNotEmpty())
            <section class="mt-8 rounded-[2rem] border border-white/10 bg-black/20 p-6 backdrop-blur-xl sm:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Nghệ sĩ</p>
                <h2 class="mt-2 text-2xl font-bold">{{ $searchArtists->count() }} kết quả</h2>

                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                    @foreach ($searchArtists as $artist)
                        <div class="group flex flex-col items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.05] p-4 transition hover:bg-white/10">
                            <a href="{{ route('artists.show', $artist['id']) }}">
                                <img src="{{ $artist['image'] ?? $fallbackCover }}" alt="{{ $artist['name'] }}" class="h-20 w-20 rounded-full object-cover shadow-lg">
                            </a>
                            <a href="{{ route('artists.show', $artist['id']) }}" class="truncate text-center text-sm font-semibold text-white hover:text-fuchsia-100">{{ $artist['name'] }}</a>
                            <button type="button" class="play-artist rounded-full border border-white/10 px-4 py-2 text-xs font-semibold text-white/70 transition hover:border-fuchsia-300/50 hover:text-fuchsia-100" data-artist-id="{{ $artist['id'] }}">
                                Phát nghệ sĩ
                            </button>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($searchAlbums->isNotEmpty())
            <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 shadow-2xl backdrop-blur-xl sm:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Album</p>
                <h2 class="mt-2 text-2xl font-bold">{{ $searchAlbums->count() }} kết quả</h2>

                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                    @foreach ($searchAlbums as $album)
                        <div class="group rounded-2xl border border-white/10 bg-white/[0.05] p-4 transition hover:bg-white/10">
                            <img src="{{ $album['cover_image'] ?? $fallbackCover }}" alt="{{ $album['title'] }}" class="aspect-square w-full rounded-2xl object-cover shadow-lg">
                            <p class="mt-3 truncate font-semibold text-white">{{ $album['title'] }}</p>
                            <p class="truncate text-sm text-white/55">{{ $album['artist_name'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($searchCategories->isNotEmpty())
            <section class="mt-8 rounded-[2rem] border border-white/10 bg-black/20 p-6 backdrop-blur-xl sm:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Thể loại</p>
                <h2 class="mt-2 text-2xl font-bold">{{ $searchCategories->count() }} kết quả</h2>

                <div class="mt-5 flex flex-wrap gap-3">
                    @foreach ($searchCategories as $cat)
                        <a href="{{ route('home', ['q' => $cat['name']]) }}" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-white/70 transition hover:bg-white/10 hover:text-white">
                            {{ $cat['name'] }}
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    @endif

    @if ($featuredSong && !$searchQuery)
        <section class="mt-8 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.08] shadow-2xl shadow-violet-950/30 backdrop-blur-xl">
            <div class="grid gap-6 p-5 md:grid-cols-[minmax(0,1fr)_320px] md:p-8">
                <div class="flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Playlist nổi bật</p>
                        <h1 class="mt-4 max-w-3xl text-4xl font-extrabold leading-tight sm:text-5xl">Chạm vào bài hát và phát nhạc ngay</h1>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-violet-100/75">
                            Giao diện nghe nhạc trực tuyến hiện đại, tối ưu cho trải nghiệm người dùng. Tìm kiếm, khám phá và thưởng thức hàng ngàn bài hát với chất lượng cao. Hãy bắt đầu hành trình âm nhạc của bạn ngay hôm nay!
                        </p>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <button type="button"
                            class="play-song rounded-full bg-gradient-to-r from-fuchsia-500 to-violet-500 px-6 py-3 text-sm font-bold shadow-lg shadow-fuchsia-950/40 transition hover:brightness-110"
                            data-track-index="0">
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
                    <h2 class="mt-2 text-2xl font-bold">{{ $searchQuery ? 'Kết quả bài hát' : 'Danh sách phát' }}</h2>
                </div>
                <p class="text-sm text-white/50">{{ $songs->count() }} bài hát</p>
            </div>

            <div class="mt-5 space-y-2">
                @forelse ($songs as $index => $song)
                    <div class="group flex w-full items-center gap-4 rounded-2xl px-3 py-3 transition hover:bg-white/10">
                        <button type="button"
                            class="play-song flex min-w-0 flex-1 items-center gap-4 text-left {{ !$song['can_play'] ? 'cursor-not-allowed opacity-60' : '' }}"
                            data-track-index="{{ $index }}"
                            data-can-play="{{ $song['can_play'] ? '1' : '0' }}"
                            @if (!$song['can_play']) onclick="showVipPrompt()" @endif>
                            <span class="w-6 text-center text-sm text-white/40 group-hover:text-fuchsia-200">{{ $index + 1 }}</span>
                            <img src="{{ $song['thumbnail'] ?? $fallbackCover }}" alt="{{ $song['title'] }}" class="h-14 w-14 rounded-xl object-cover">
                            <span class="min-w-0 flex-1">
                                <span class="block truncate font-semibold">
                                    {{ $song['title'] }}
                                    @if ($song['is_vip'])
                                        <span class="ml-2 rounded-full bg-linear-to-r from-yellow-500 to-amber-500 px-2 py-0.5 text-[10px] font-bold text-black uppercase">VIP</span>
                                    @endif
                                </span>
                                <span class="mt-1 block truncate text-sm text-white/55">{{ $song['artist'] }} • {{ $song['category'] }}</span>
                            </span>
                            <span class="hidden text-sm text-white/45 sm:block">{{ number_format((int) $song['listen_count']) }} lượt nghe</span>
                            <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-white/60 group-hover:border-fuchsia-300/50 group-hover:text-fuchsia-100">
                                {{ $song['can_play'] ? 'Play' : '🔒 VIP' }}
                            </span>
                        </button>

                        @auth
                            <form action="{{ route('favorites.toggle', $song['id']) }}" method="POST" class="favorite-toggle-form" data-song-id="{{ $song['id'] }}">
                                @csrf
                                <button type="submit"
                                    data-favorite-button
                                    data-liked-class="flex h-10 w-10 items-center justify-center rounded-full border border-fuchsia-300/40 bg-fuchsia-500/20 text-fuchsia-100 transition hover:bg-fuchsia-500/30 disabled:cursor-not-allowed disabled:opacity-60"
                                    data-unliked-class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 text-white/45 transition hover:bg-white/10 hover:text-fuchsia-100 disabled:cursor-not-allowed disabled:opacity-60"
                                    class="{{ $song['is_liked'] ? 'flex h-10 w-10 items-center justify-center rounded-full border border-fuchsia-300/40 bg-fuchsia-500/20 text-fuchsia-100 transition hover:bg-fuchsia-500/30 disabled:cursor-not-allowed disabled:opacity-60' : 'flex h-10 w-10 items-center justify-center rounded-full border border-white/10 text-white/45 transition hover:bg-white/10 hover:text-fuchsia-100 disabled:cursor-not-allowed disabled:opacity-60' }}"
                                    title="{{ $song['is_liked'] ? 'Bỏ yêu thích' : 'Thêm yêu thích' }}">
                                    {{ $song['is_liked'] ? '♥' : '♡' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 text-white/45 transition hover:bg-white/10 hover:text-fuchsia-100" title="Đăng nhập để yêu thích">♡</a>
                        @endauth
                    </div>
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
                    <button type="button" class="play-song flex w-full items-center gap-3 rounded-2xl bg-white/[0.05] p-3 text-left transition hover:bg-white/10 {{ !$song['can_play'] ? 'cursor-not-allowed opacity-60' : '' }}" data-track-index="{{ $songs->search(fn ($item) => $item['id'] === $song['id']) }}" data-can-play="{{ $song['can_play'] ? '1' : '0' }}" @if (!$song['can_play']) onclick="showVipPrompt()" @endif>
                        <span class="text-xl font-black text-fuchsia-300">{{ $index + 1 }}</span>
                        <img src="{{ $song['thumbnail'] ?? $fallbackCover }}" alt="{{ $song['title'] }}" class="h-12 w-12 rounded-xl object-cover">
                        <span class="min-w-0">
                            <span class="block truncate text-sm font-semibold">{{ $song['title'] }} @if ($song['is_vip']) <span class="ml-2 rounded-full bg-linear-to-r from-yellow-500 to-amber-500 px-2 py-0.5 text-[10px] font-bold text-black uppercase">VIP</span> @endif</span>
                            <span class="mt-1 block truncate text-xs text-white/50">{{ $song['artist'] }}</span>
                        </span>
                        @if (!$song['can_play'])
                            <span class="text-xs text-yellow-400/70">🔒</span>
                        @endif
                    </button>
                @empty
                    <p class="text-sm text-white/55">Chưa có dữ liệu xếp hạng.</p>
                @endforelse
            </div>
        </aside>
    </section>

    @if (!$searchQuery && $artists->isNotEmpty())
        <section id="artists" class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.07] p-5 backdrop-blur-xl sm:p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Nghệ sĩ</p>
                    <h2 class="mt-2 text-2xl font-bold">Phát theo nghệ sĩ</h2>
                </div>
                <p class="text-sm text-white/50">{{ $artists->count() }} nghệ sĩ</p>
            </div>

            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($artists as $artist)
                    <article class="flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.05] p-4">
                        <img src="{{ $artist['image'] ?? $fallbackCover }}" alt="{{ $artist['name'] }}" class="h-16 w-16 rounded-full object-cover">
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('artists.show', $artist['id']) }}" class="truncate font-semibold text-white hover:text-fuchsia-100">{{ $artist['name'] }}</a>
                            <p class="mt-1 text-sm text-white/50">{{ $artist['songs_count'] }} bài hát</p>
                        </div>
                        <button type="button" class="play-artist rounded-full bg-white px-4 py-2 text-xs font-bold text-[#170f2f] transition hover:bg-violet-100" data-artist-id="{{ $artist['id'] }}">
                            Play
                        </button>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if ($podcasts->isNotEmpty())
        <section id="podcasts" class="mt-8 rounded-[2rem] border border-white/10 bg-black/20 p-5 backdrop-blur-xl sm:p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Podcast</p>
                    <h2 class="mt-2 text-2xl font-bold">Podcast mới</h2>
                </div>
                <p class="text-sm text-white/50">{{ $podcasts->count() }} tập</p>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($podcasts as $index => $podcast)
                    <article class="group flex gap-4 rounded-2xl border border-white/10 bg-white/[0.05] p-4 transition hover:bg-white/10">
                        <img src="{{ $podcast['thumbnail'] ?? $fallbackCover }}" alt="{{ $podcast['title'] }}" class="h-20 w-20 rounded-2xl object-cover">
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('podcasts.show', $podcast['id']) }}" class="line-clamp-1 font-semibold text-white hover:text-fuchsia-100">{{ $podcast['title'] }}</a>
                            <p class="mt-1 line-clamp-2 text-sm text-white/55">{{ $podcast['description'] ?: 'Podcast' }}</p>
                            <div class="mt-3 flex items-center gap-3">
                                <button type="button" class="play-song rounded-full border border-white/10 px-4 py-2 text-xs font-semibold text-white/70 transition group-hover:border-fuchsia-300/50 group-hover:text-fuchsia-100" data-track-index="{{ $songCount + $index }}" data-can-play="1">
                                    Phát podcast
                                </button>
                                <span class="text-xs text-white/45">{{ number_format((int) $podcast['listen_count']) }} lượt nghe</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if (!$hasActiveSubscription && $activeAds->isNotEmpty())
        <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.06] p-5 backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Quảng cáo</p>
                <span class="text-xs text-white/50">Nâng cấp gói để tắt quảng cáo</span>
            </div>

            <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($activeAds as $ad)
                    <a href="{{ $ad->link_url ?: '#' }}" target="_blank" rel="noopener noreferrer" class="group block overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] transition hover:bg-white/[0.08]">
                        @if ($ad->image_url)
                            <img src="{{ \App\Support\ImageUpload::url($ad->image_url) }}" alt="{{ $ad->title }}" class="h-44 w-full object-cover transition duration-300 group-hover:scale-[1.02]">
                        @endif
                        <div class="p-4">
                            <h3 class="line-clamp-1 font-semibold text-white">{{ $ad->title }}</h3>
                            @if ($ad->description)
                                <p class="mt-1 line-clamp-2 text-sm text-white/60">{{ $ad->description }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@section('player')
    <footer class="fixed inset-x-0 bottom-0 z-50 border-t border-white/10 bg-[#120b24]/95 px-4 py-3 shadow-2xl shadow-black/60 backdrop-blur-xl">
        <div class="mx-auto flex max-w-[1500px] flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex min-w-0 items-center gap-3 max-w-[300px] w-full">
                <img id="playerCover" src="{{ $initialTrack['thumbnail'] ?? $fallbackCover }}" alt="Đang phát" class="h-14 w-14 rounded-2xl object-cover">
                <div class="min-w-0">
                    <p id="playerTitle" class="truncate font-semibold">{{ $initialTrack['title'] ?? 'Chưa chọn nội dung' }}</p>
                    <p id="playerArtist" class="truncate text-sm text-white/55">{{ $initialTrack['subtitle'] ?? 'Chọn một bài hát hoặc podcast' }}</p>
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
        const podcasts = @json($podcasts);
        const tracks = [...songs, ...podcasts];
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
        let activeQueue = tracks.map((track, index) => index);
        let isSeeking = false;
        let progressInterval = null;

        function formatTime(seconds) {
            if (!Number.isFinite(seconds)) {
                return '0:00';
            }

            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = Math.floor(seconds % 60).toString().padStart(2, '0');
            return `${minutes}:${remainingSeconds}`;
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

        function showVipPrompt() {
            window.showWebToast('Bài hát VIP. Vui lòng mua gói đăng ký để nghe và tắt quảng cáo.', 'error');
        }

        function loadSong(index, shouldPlay = false) {
            loadTrack(index, shouldPlay);
        }

        function loadTrack(index, shouldPlay = false) {
            if (!tracks.length || !tracks[index]) {
                return;
            }

            currentIndex = index;
            const track = tracks[currentIndex];

            if (!track.can_play || !track.audio_url) {
                showVipPrompt();
                return;
            }

            audio.src = track.audio_url;
            playerCover.src = track.thumbnail || fallbackCover;
            playerTitle.textContent = track.title;
            playerArtist.textContent = track.type === 'podcast'
                ? 'Podcast'
                : track.artist;
            seekBar.value = 0;
            currentTime.textContent = '0:00';
            duration.textContent = '0:00';

            if (shouldPlay) {
                audio.play();
            }
        }

        function playNextInQueue(direction = 1) {
            if (!activeQueue.length) {
                return;
            }

            const queuePosition = activeQueue.indexOf(currentIndex);
            const safePosition = queuePosition === -1 ? 0 : queuePosition;
            const nextPosition = (safePosition + direction + activeQueue.length) % activeQueue.length;
            loadTrack(activeQueue[nextPosition], true);
        }

        function playCurrent() {
            const track = tracks[currentIndex];
            if (!track || !track.can_play) {
                showVipPrompt();
                return;
            }

            if (!audio.src) {
                loadSong(currentIndex);
            }

            audio.play();
        }

        document.querySelectorAll('.play-song').forEach((button) => {
            button.addEventListener('click', () => {
                const canPlay = button.dataset.canPlay === '1';
                if (!canPlay) {
                    showVipPrompt();
                    return;
                }
                activeQueue = tracks.map((track, index) => index);
                loadTrack(Number(button.dataset.trackIndex), true);
            });
        });

        document.querySelectorAll('.play-artist').forEach((button) => {
            button.addEventListener('click', () => {
                const artistId = Number(button.dataset.artistId);
                const artistQueue = tracks
                    .map((track, index) => ({ track, index }))
                    .filter(({ track }) => {
                        return track.type === 'song'
                            && Number(track.artist_id) === artistId
                            && track.can_play
                            && track.audio_url;
                    })
                    .map(({ index }) => index);

                const artistTrackIndex = artistQueue[0] ?? -1;

                const hasBlockedSongs = tracks.some((track) => {
                    return track.type === 'song'
                        && Number(track.artist_id) === artistId
                        && track.audio_url;
                });

                if (artistTrackIndex === -1) {
                    window.showWebToast(
                        hasBlockedSongs
                            ? 'Bài hát của nghệ sĩ này cần gói VIP để phát.'
                            : 'Nghệ sĩ này chưa có bài hát khả dụng để phát.',
                        'error'
                    );
                    return;
                }

                activeQueue = artistQueue;
                loadTrack(artistTrackIndex, true);
            });
        });

        playButton.addEventListener('click', () => {
            if (audio.paused) {
                playCurrent();
            } else {
                audio.pause();
            }
        });

        prevButton.addEventListener('click', () => {
            if (!tracks.length) {
                return;
            }

            playNextInQueue(-1);
        });

        nextButton.addEventListener('click', () => {
            if (!tracks.length) {
                return;
            }

            playNextInQueue(1);
        });

        audio.addEventListener('play', () => {
            playButton.textContent = '❚❚';

            // Track listening history
            @auth
            const track = tracks[currentIndex];
            if (track && track.type === 'song' && track.id) {
                fetch(`/listening-history/${track.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                }).catch(() => {});

                // Start progress tracking every 10 seconds
                if (progressInterval) {
                    clearInterval(progressInterval);
                }
                progressInterval = setInterval(() => {
                    sendProgress(track.id);
                }, 10000);
            }
            @endauth
        });

        audio.addEventListener('pause', () => {
            playButton.textContent = '▶';

            // Stop progress tracking
            if (progressInterval) {
                clearInterval(progressInterval);
                progressInterval = null;
            }
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
            if (!tracks.length) {
                return;
            }

            playNextInQueue(1);
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
        const firstPlayableIndex = tracks.findIndex((track) => track.can_play && track.audio_url);
        if (firstPlayableIndex !== -1) {
            currentIndex = firstPlayableIndex;
            loadTrack(firstPlayableIndex);
        }
    </script>
@endpush
