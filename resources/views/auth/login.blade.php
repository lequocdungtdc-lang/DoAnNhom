@extends('layouts.web', ['title' => 'Đăng nhập'])

@section('content')
    <div class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-[1.1fr_0.9fr]">
        <section class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur">
            <p class="mb-3 text-sm uppercase tracking-[0.3em] text-orange-300/80">Chào mừng quay lại</p>
            <h1 class="max-w-xl text-4xl font-semibold leading-tight text-white">Đăng nhập vào hệ thống để quản lý tài khoản và nội dung của bạn.</h1>
        </section>

        <section class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-8 shadow-2xl">
            <h2 class="text-2xl font-semibold text-white">Đăng nhập</h2>
            <p class="mt-2 text-sm text-stone-400">Nhập email và mật khẩu của bạn.</p>

            <form action="{{ route('login.submit') }}" method="POST" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-stone-200">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none ring-0 placeholder:text-stone-500 focus:border-orange-400" placeholder="you@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-stone-200">Mật khẩu</label>
                    <input id="password" name="password" type="password" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400" placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 text-sm text-stone-300">
                    <input type="checkbox" name="remember" class="rounded border-white/20 bg-white/5 text-orange-500 focus:ring-orange-400">
                    Ghi nhớ đăng nhập
                </label>

                <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 font-semibold text-stone-950 transition hover:bg-orange-400">Đăng nhập</button>
            </form>

            <p class="mt-6 text-sm text-stone-400">Chưa có tài khoản? <a href="{{ route('register') }}" class="font-medium text-orange-300 hover:text-orange-200">Đăng ký ngay</a></p>
        </section>
    </div>
@endsection
