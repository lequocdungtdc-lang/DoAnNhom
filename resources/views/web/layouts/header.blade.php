<header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white/80 transition hover:bg-white/15 lg:hidden">Music Hub</a>
        <form action="{{ route('home') }}" method="GET" class="relative w-full max-w-xl md:w-105">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm bài hát, nghệ sĩ, album"
                class="w-full rounded-full border border-white/10 bg-white/10 px-5 py-3 text-sm text-white outline-none placeholder:text-white/50 backdrop-blur transition focus:border-fuchsia-400">
        </form>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="hidden rounded-full border border-white/10 px-4 py-2 text-sm text-white/70 transition hover:bg-white/10 sm:inline-flex">Home</a>
        <a href="{{ route('news.index') }}" class="hidden rounded-full border border-white/10 px-4 py-2 text-sm text-white/70 transition hover:bg-white/10 sm:inline-flex">News</a>

        @auth
            <div class="group relative">
                <button type="button" class="flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm text-white/80 transition hover:bg-white/10">
                    <span>Tài khoản</span>
                    <span class="text-xs text-white/45 transition group-hover:rotate-180">⌄</span>
                </button>

                <div class="invisible absolute right-0 top-full z-50 w-72 translate-y-2 pt-3 opacity-0 transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                    <div class="rounded-3xl border border-white/10 bg-[#160f2c]/95 p-3 shadow-2xl shadow-black/40 backdrop-blur-xl">
                        <div class="border-b border-white/10 px-3 py-3">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->fullname }}</p>
                            <p class="mt-1 truncate text-xs text-white/45">{{ auth()->user()->email }}</p>
                        </div>

                        <div class="py-2">
                            <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'dashboard') }}" class="flex items-center justify-between rounded-2xl px-3 py-2.5 text-sm text-white/75 transition hover:bg-white/10 hover:text-white">
                                <span>Tổng quan tài khoản</span>
                                <span class="text-xs text-white/35">›</span>
                            </a>
                            <a href="{{ route('profile') }}" class="flex items-center justify-between rounded-2xl px-3 py-2.5 text-sm text-white/75 transition hover:bg-white/10 hover:text-white">
                                <span>Profile</span>
                                <span class="text-xs text-white/35">›</span>
                            </a>
                            <a href="{{ route('plans.index') }}" class="flex items-center justify-between rounded-2xl px-3 py-2.5 text-sm text-white/75 transition hover:bg-white/10 hover:text-white">
                                <span>Gói đăng ký</span>
                                @if (auth()->user()->activeSubscription)
                                    <span class="rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-bold text-emerald-300 uppercase">VIP</span>
                                @else
                                    <span class="text-xs text-white/35">›</span>
                                @endif
                            </a>
                            <a href="{{ route('favorites.index') }}" class="flex items-center justify-between rounded-2xl px-3 py-2.5 text-sm text-white/75 transition hover:bg-white/10 hover:text-white">
                                <span>Bài hát yêu thích</span>
                                <span class="text-xs text-white/35">›</span>
                            </a>
                            <a href="#" class="flex items-center justify-between rounded-2xl px-3 py-2.5 text-sm text-white/55 transition hover:bg-white/10 hover:text-white">
                                <span>Danh sách phát của tôi</span>
                                <span class="rounded-full bg-white/10 px-2 py-0.5 text-[10px] text-white/45">Sắp có</span>
                            </a>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="border-t border-white/10 pt-2">
                            @csrf
                            <button type="submit" class="flex w-full items-center justify-between rounded-2xl px-3 py-2.5 text-left text-sm text-red-200 transition hover:bg-red-500/10">
                                <span>Logout</span>
                                <span class="text-xs text-red-200/45">↗</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm text-white/80 transition hover:bg-white/10">Đăng nhập</a>
            <a href="{{ route('register') }}" class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#170f2f] transition hover:bg-violet-100">Đăng ký</a>
        @endauth
    </div>
</header>
