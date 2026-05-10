<header class="border-b border-white/8 px-4 py-4 md:px-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.28em] text-[#8a93a3]">Không gian quản trị</p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-white">Quản lý hệ thống</h1>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <div class="flex items-center gap-2 rounded-2xl border border-white/8 bg-white/[0.03] px-4 py-3 text-sm text-[#aeb6c3]">
                <svg class="h-4 w-4 text-[#7b8494]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0a7 7 0 0 1 14 0Z" />
                </svg>
                <span>Tìm trang, người dùng, nội dung</span>
            </div>

            <div class="flex items-center justify-between gap-3 rounded-2xl border border-white/8 bg-white/[0.04] px-4 py-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-[#10a37f]/14 text-sm font-semibold text-[#7ef0cf]">
                    {{ strtoupper(substr(auth()->user()->fullname ?? 'AD', 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->fullname ?? 'Admin' }}</p>
                    <p class="text-xs text-[#8a93a3]">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-xl border border-white/10 px-3 py-2 text-sm text-[#d7dde8] transition hover:border-[#10a37f]/40 hover:bg-white/5 hover:text-white">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
