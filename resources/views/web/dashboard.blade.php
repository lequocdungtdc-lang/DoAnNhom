@extends('layouts.web', ['title' => 'Bảng điều khiển'])

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <section class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur">
            <p class="text-sm uppercase tracking-[0.3em] text-orange-300/80">Bảng điều khiển</p>
            <h1 class="mt-3 text-4xl font-semibold text-white">Xin chào, {{ auth()->user()->fullname }}</h1>
            <p class="mt-4 max-w-2xl text-sm leading-7 text-stone-300">Phần lõi xác thực cơ bản đã sẵn sàng: đăng nhập, đăng ký, đăng xuất, bảng điều khiển, cập nhật hồ sơ, chuyển hướng theo role và build asset bằng Tailwind + Vite.</p>
        </section>

        <section class="space-y-4">
            <div class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl">
                <p class="text-sm text-stone-400">Email</p>
                <p class="mt-2 text-lg font-semibold text-white">{{ auth()->user()->email }}</p>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl">
                <p class="text-sm text-stone-400">Vai trò</p>
                <p class="mt-2 text-lg font-semibold capitalize text-white">{{ auth()->user()->role }}</p>
            </div>

            <div class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-6 shadow-2xl">
                <a href="{{ route('profile') }}" class="inline-flex rounded-full bg-orange-500 px-4 py-2 font-medium text-stone-950 transition hover:bg-orange-400">Cập nhật hồ sơ</a>
            </div>
        </section>
    </div>
@endsection
