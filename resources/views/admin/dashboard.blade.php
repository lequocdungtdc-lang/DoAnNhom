@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">
    <div class="grid gap-5 xl:grid-cols-[1.25fr_0.75fr]">
        <div class="admin-card overflow-hidden">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <span class="admin-chip">Tổng quan quản trị</span>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-white md:text-4xl">Xin chào, {{ auth()->user()->fullname }}</h2>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-[#9aa3b2]">
                        Đây là giao diện quản trị mới theo hướng tối giản, sáng rõ, tập trung vào panel và số liệu, phù hợp để phát triển thêm quản lý người dùng, thể loại, bài hát và album.
                    </p>
                </div>

                <div class="grid min-w-[220px] gap-3">
                    <div class="rounded-2xl border border-white/8 bg-black/20 p-4">
                        <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Vai trò hiện tại</p>
                        <p class="mt-3 text-2xl font-semibold capitalize text-white">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/8 bg-[#10a37f]/10 p-4">
                        <p class="text-xs uppercase tracking-[0.24em] text-[#8dddc7]">Phiên đăng nhập</p>
                        <p class="mt-3 text-sm font-medium text-[#d7fff4]">Đã xác thực và sẵn sàng</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Người vận hành</p>
            <div class="mt-5 flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/8 text-lg font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->fullname ?? 'AD', 0, 2)) }}
                </div>
                <div>
                    <p class="text-lg font-semibold text-white">{{ auth()->user()->fullname }}</p>
                    <p class="text-sm text-[#8a93a3]">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="mt-6 grid gap-3">
                <a href="{{ route('profile') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-medium text-[#d5dce7] transition hover:border-[#10a37f]/40 hover:bg-white/5 hover:text-white">Sửa hồ sơ</a>
                <a href="{{ route('home') }}" target="_blank" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-medium text-[#d5dce7] transition hover:border-[#10a37f]/40 hover:bg-white/5 hover:text-white">Xem trang web</a>
            </div>
        </div>
    </div>

    <div class="mt-5 grid gap-5 md:grid-cols-2 2xl:grid-cols-4">
        <article class="admin-card">
            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Người dùng</p>
            <p class="mt-4 text-3xl font-semibold text-white">{{ $totalUsers }}</p>
            <p class="mt-2 text-sm text-[#8a93a3]">Tổng người dùng đang hoạt động trong hệ thống.</p>
        </article>

        <article class="admin-card">
            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Nội dung</p>
            <p class="mt-4 text-3xl font-semibold text-white">{{ $totalContents }}</p>
            <p class="mt-2 text-sm text-[#8a93a3]">Bài hát, album và thể loại đang được quản lý.</p>
        </article>

        <article class="admin-card">
            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Hàng chờ duyệt</p>
            <p class="mt-4 text-3xl font-semibold text-white">12</p>
            <p class="mt-2 text-sm text-[#8a93a3]">Nội dung cần duyệt hoặc cập nhật trong ngày.</p>
        </article>

        <article class="admin-card">
            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Sức khỏe hệ thống</p>
            <p class="mt-4 text-3xl font-semibold text-[#7ef0cf]">99.9%</p>
            <p class="mt-2 text-sm text-[#8a93a3]">Trạng thái uptime và pipeline asset ổn định.</p>
        </article>
    </div>

    <div class="mt-5 grid gap-5 xl:grid-cols-[0.9fr_1.1fr]">
        <div class="admin-card">
            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Thao tác nhanh</p>
            <div class="mt-5 grid gap-3">

                <a href="{{ route('admin.songs.index') }}" class="flex items-center justify-between rounded-2xl border border-white/8 bg-white/[0.02] px-4 py-4 text-sm text-white transition hover:bg-white/[0.05]">
                    <span>Mở bài hát</span>
                    <span class="text-[#8a93a3]">Songs</span>
                </a>
                <a href="{{ route('admin.podcasts.index') }}" class="flex items-center justify-between rounded-2xl border border-white/8 bg-white/[0.02] px-4 py-4 text-sm text-white transition hover:bg-white/[0.05]">
                    <span>Mở podcast</span>
                    <span class="text-[#8a93a3]">Podcasts</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-between rounded-2xl border border-white/8 bg-white/[0.02] px-4 py-4 text-sm text-white transition hover:bg-white/[0.05]">
                    <span>Mở thể loại</span>
                    <span class="text-[#8a93a3]">Categories</span>
                </a>
                <a href="{{ route('admin.activities.index') }}" class="flex items-center justify-between rounded-2xl border border-white/8 bg-white/[0.02] px-4 py-4 text-sm text-white transition hover:bg-white/[0.05]">
                    <span>Mở hoạt động</span>
                    <span class="text-[#8a93a3]">Activities</span>
                </a>

            </div>
        </div>

        <div class="admin-card">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Hoạt động gần đây</p>
                    <h3 class="mt-2 text-xl font-semibold text-white">Bảng tin</h3>
                </div>

            </div>

            <div class="mt-6 space-y-4">

                @foreach ($randomComments as $comment)

                <div class="rounded-2xl border border-white/8 bg-black/15 p-4">

                    <div class="flex items-center gap-3">

                        <img
                            src="{{ $comment->user->avatar }}"
                            class="h-10 w-10 rounded-full object-cover">

                        <div>

                            <p class="text-sm font-medium text-white">
                                {{ $comment->user->fullname }}
                            </p>

                            <p class="text-xs text-[#7f8898]">
                                {{ $comment->song->title }}
                            </p>

                        </div>

                    </div>

                    <p class="mt-3 text-sm text-[#8a93a3]">
                        {{ $comment->content }}
                    </p>

                </div>

                @endforeach

            </div>
        </div>
    </div>
</section>
@endsection