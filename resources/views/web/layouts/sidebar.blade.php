<aside class="hidden border-r border-white/10 bg-black/15 px-5 py-6 backdrop-blur-xl lg:block">
    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-500 to-violet-500 text-xl font-black">M</div>
            <div>
                <p class="text-lg font-bold tracking-tight">Music Hub</p>
                <p class="text-xs text-violet-200/70">Nghe nhạc online</p>
            </div>
        </a>
    </div>

    <nav class="mt-8 space-y-2 text-sm font-medium">
        <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('home') ? 'bg-white/10 text-white shadow-lg shadow-violet-950/30' : 'text-white/55 hover:bg-white/10 hover:text-white' }}">
            <span>{{ request()->routeIs('home') ? '●' : '○' }}</span>
            Khám phá
        </a>
        <a href="{{ route('news.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('news.*') ? 'bg-white/10 text-white shadow-lg shadow-violet-950/30' : 'text-white/55 hover:bg-white/10 hover:text-white' }}">
            <span>{{ request()->routeIs('news.*') ? '●' : '○' }}</span>
            Tin tức
        </a>
        <a href="{{ route('rankings') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-white/55 transition hover:bg-white/10 hover:text-white">
            <span>○</span>
            BXH nhạc mới
        </a>
        <a href="{{ route('podcasts.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('podcasts.*') ? 'bg-white/10 text-white shadow-lg shadow-violet-950/30' : 'text-white/55 hover:bg-white/10 hover:text-white' }}">
            <span>○</span>
            Podcast
        </a>
        <a href="{{ route('artists.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('artists.*') ? 'bg-white/10 text-white shadow-lg shadow-violet-950/30' : 'text-white/55 hover:bg-white/10 hover:text-white' }}">
            <span>○</span>
            Nghệ sĩ
        </a>
        <a href="{{ route('playlists.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('artists.*') ? 'bg-white/10 text-white shadow-lg shadow-violet-950/30' : 'text-white/55 hover:bg-white/10 hover:text-white' }}">
            <span>○</span>
            Danh sách phát của tôi
        </a>

    </nav>

    <div class="mt-8 rounded-3xl border border-white/10 bg-white/[0.06] p-4">
        <p class="text-sm font-semibold">Gợi ý hôm nay</p>
        <p class="mt-2 text-xs leading-5 text-violet-100/70">Chọn một bài hát bất kỳ để phát bằng player phía dưới.</p>
    </div>
</aside>