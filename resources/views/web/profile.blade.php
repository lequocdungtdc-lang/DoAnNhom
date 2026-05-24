@extends('layouts.web', ['title' => 'Hồ sơ'])

@section('content')
    <div class="mx-auto max-w-3xl rounded-[2rem] border border-white/10 bg-stone-900/80 p-8 shadow-2xl">
        <h1 class="text-3xl font-semibold text-white">Thông tin tài khoản</h1>
        <p class="mt-2 text-sm text-stone-400">Cập nhật các thông tin cơ bản của bạn.</p>

        <form action="{{ route('profile.update') }}" method="POST" class="mt-8 space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="fullname" class="mb-2 block text-sm font-medium text-stone-200">Họ và tên</label>
                <input id="fullname" name="fullname" type="text" value="{{ old('fullname', $user->fullname) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400">
                @error('fullname')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-stone-200">Email</label>
                    <input id="email" type="email" value="{{ $user->email }}" disabled class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-stone-400">
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-stone-200">Số điện thoại</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400">
                </div>
            </div>

            <div>
                <label for="address" class="mb-2 block text-sm font-medium text-stone-200">Địa chỉ</label>
                <textarea id="address" name="address" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-stone-500 focus:border-orange-400">{{ old('address', $user->address) }}</textarea>
            </div>

            <button type="submit" class="rounded-2xl bg-orange-500 px-5 py-3 font-semibold text-stone-950 transition hover:bg-orange-400">Lưu thay đổi</button>
        </form>
    </div>
@endsection
