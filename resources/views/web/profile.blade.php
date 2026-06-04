@extends('web.master', ['title' => 'Hồ sơ'])

@section('content')
    <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 shadow-2xl shadow-violet-950/30 backdrop-blur-xl sm:p-8">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Tài khoản cá nhân</p>
        <h1 class="mt-3 text-4xl font-extrabold leading-tight">Thông tin hồ sơ</h1>
        <p class="mt-3 max-w-2xl text-sm leading-6 text-violet-100/75">
            Cập nhật thông tin cơ bản để cá nhân hóa trải nghiệm nghe nhạc của bạn trên Music Hub.
        </p>
    </section>

    <section class="mt-8 mx-auto max-w-4xl rounded-[2rem] border border-white/10 bg-black/20 p-6 shadow-2xl backdrop-blur-xl sm:p-8">
        @if (session('message'))
            <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/15 px-4 py-3 text-sm text-emerald-100">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-violet-200/70">Thông tin chính</p>

                <div class="mt-4 grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="fullname" class="mb-2 block text-sm font-medium text-stone-200">Họ và tên</label>
                        <input id="fullname" name="fullname" type="text" value="{{ old('fullname', $user->fullname) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 transition focus:border-fuchsia-400">
                        @error('fullname')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-stone-200">Email</label>
                        <input id="email" type="email" value="{{ $user->email }}" disabled class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-stone-400">
                    </div>

                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium text-stone-200">Số điện thoại</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 transition focus:border-fuchsia-400">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-violet-200/70">Địa chỉ liên hệ</p>

                <div class="mt-4">
                    <label for="address" class="mb-2 block text-sm font-medium text-stone-200">Địa chỉ</label>
                    <textarea id="address" name="address" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 transition focus:border-fuchsia-400">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" class="rounded-full bg-gradient-to-r from-fuchsia-500 to-violet-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-fuchsia-950/40 transition hover:brightness-110">
                    Lưu thay đổi
                </button>
                <a href="{{ route('dashboard') }}" class="rounded-full border border-white/10 px-5 py-3 text-sm text-white/70 transition hover:bg-white/10">
                    Quay lại dashboard
                </a>
            </div>
        </form>
    </section>
@endsection
