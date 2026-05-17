@extends('web.master', ['title' => 'Bảng điều khiển'])

@section('content')
    <section class="mt-8 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.08] shadow-2xl shadow-violet-950/30 backdrop-blur-xl">
        <div class="p-8">
            <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Tổng quan tài khoản</p>
            <h1 class="mt-4 text-4xl font-extrabold leading-tight sm:text-5xl">Xin chào, {{ auth()->user()->fullname }}</h1>
            <p class="mt-4 max-w-2xl text-sm leading-6 text-violet-100/75">
                Chào mừng bạn quay trở lại Music Hub. Khám phá âm nhạc, quản lý thông tin cá nhân và tận hưởng trải nghiệm nghe nhạc tuyệt vời.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-white/[0.05] p-5 backdrop-blur">
                    <p class="text-xs font-medium uppercase tracking-wider text-violet-200/70">Email</p>
                    <p class="mt-2 truncate text-lg font-semibold text-white">{{ auth()->user()->email }}</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.05] p-5 backdrop-blur">
                    <p class="text-xs font-medium uppercase tracking-wider text-violet-200/70">Vai trò</p>
                    <p class="mt-2 text-lg font-semibold capitalize text-white">{{ auth()->user()->role }}</p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.05] p-5 backdrop-blur">
                    <p class="text-xs font-medium uppercase tracking-wider text-violet-200/70">Trạng thái</p>
                    <p class="mt-2 text-lg font-semibold text-white">
                        <span class="inline-flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-green-400"></span>
                            Hoạt động
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 rounded-[2rem] border border-white/10 bg-black/20 p-6 backdrop-blur-xl">
        <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Hành động nhanh</p>
        <h2 class="mt-2 text-2xl font-bold">Quản lý tài khoản</h2>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('profile') }}" class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.05] p-5 transition hover:bg-white/10">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-fuchsia-500 to-violet-500">
                    <span class="text-xl">👤</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-white">Cập nhật hồ sơ</p>
                    <p class="mt-1 text-xs text-white/55">Chỉnh sửa thông tin cá nhân</p>
                </div>
                <span class="text-white/35 transition group-hover:text-white/70">›</span>
            </a>

            <a href="{{ route('favorites.index') }}" class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.05] p-5 transition hover:bg-white/10">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-pink-500 to-rose-500">
                    <span class="text-xl">♥</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-white">Bài hát yêu thích</p>
                    <p class="mt-1 text-xs text-white/55">Xem danh sách yêu thích</p>
                </div>
                <span class="text-white/35 transition group-hover:text-white/70">›</span>
            </a>

            <div class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.03] p-5 opacity-60">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-purple-500">
                    <span class="text-xl">⚙️</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-white">Cài đặt</p>
                    <p class="mt-1 text-xs text-white/55">Tùy chỉnh tài khoản</p>
                </div>
                <span class="rounded-full bg-white/10 px-2 py-0.5 text-[10px] text-white/45">Sắp có</span>
            </div>
        </div>
    </section>

    <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 shadow-2xl backdrop-blur-xl">
        <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Hoạt động gần đây</p>
        <h2 class="mt-2 text-2xl font-bold">Lịch sử của bạn</h2>

        <div class="mt-6 rounded-3xl border border-dashed border-white/15 p-8 text-center text-white/60">
            Tính năng lịch sử nghe nhạc đang được phát triển. Hãy quay lại sau để xem các bài hát bạn đã nghe gần đây.
        </div>
    </section>
@endsection
