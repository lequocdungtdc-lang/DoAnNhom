@extends('web.master', ['title' => 'Đăng ký'])

@section('content')
    <div class="mx-auto grid max-w-5xl  my-5">
        <section class="rounded-[2rem] border border-white/10 bg-stone-900/80 p-8 shadow-2xl">
            <h2 class="text-2xl font-semibold text-white">Tạo tài khoản</h2>
            <p class="mt-2 text-sm text-stone-400">Đăng ký nhanh để bắt đầu sử dụng hệ thống.</p>

            <form action="{{ route('register.submit') }}" method="POST" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="fullname" class="mb-2 block text-sm font-medium text-stone-200">Họ và tên</label>
                    <input id="fullname" name="fullname" type="text" value="{{ old('fullname') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400" placeholder="Nguyen Van A">
                    @error('fullname')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-stone-200">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400" placeholder="you@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-stone-200">Số điện thoại</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400" placeholder="0900000000">
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-stone-200">Mật khẩu</label>
                        <input id="password" name="password" type="password" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400" placeholder="Tối thiểu 6 ký tự">
                        @error('password')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-stone-200">Xác nhận mật khẩu</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400" placeholder="Nhập lại mật khẩu">
                    </div>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-orange-500 px-4 py-3 font-semibold text-stone-950 transition hover:bg-orange-400">Đăng ký</button>
            </form>

            <p class="mt-6 text-sm text-stone-400">Đã có tài khoản? <a href="{{ route('login') }}" class="font-medium text-orange-300 hover:text-orange-200">Đăng nhập</a></p>
        </section>

    </div>
@endsection
