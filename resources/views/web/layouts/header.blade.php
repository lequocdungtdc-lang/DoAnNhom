<header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white/80 transition hover:bg-white/15 lg:hidden">Music Hub</a>
        <div class="relative w-full max-w-xl md:w-[420px]">
            <input type="text" disabled value="Tìm kiếm bài hát, nghệ sĩ, album"
                class="w-full rounded-full border border-white/10 bg-white/10 px-5 py-3 text-sm text-white/50 outline-none backdrop-blur">
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="hidden rounded-full border border-white/10 px-4 py-2 text-sm text-white/70 transition hover:bg-white/10 sm:inline-flex">Home</a>
        <a href="{{ route('news.index') }}" class="hidden rounded-full border border-white/10 px-4 py-2 text-sm text-white/70 transition hover:bg-white/10 sm:inline-flex">News</a>

        @auth
            <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'dashboard') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm text-white/80 transition hover:bg-white/10">Tài khoản</a>
        @else
            <a href="{{ route('login') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm text-white/80 transition hover:bg-white/10">Đăng nhập</a>
            <a href="{{ route('register') }}" class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#170f2f] transition hover:bg-violet-100">Đăng ký</a>
        @endauth
    </div>
</header>
