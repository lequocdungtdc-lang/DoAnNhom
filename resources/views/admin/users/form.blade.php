@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="mx-auto max-w-4xl admin-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Người dùng</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">{{ $isEdit ? 'Cập nhật người dùng' : 'Tạo người dùng mới' }}</h2>
                </div>
                <a href="{{ route('admin.users.index') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">Quay lại</a>
            </div>

            <form action="{{ $isEdit ? route('admin.users.update', $userItem->id) : route('admin.users.store') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Họ và tên</label>
                        <input name="fullname" value="{{ old('fullname', $userItem->fullname) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        @error('fullname') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Email</label>
                        <input name="email" type="email" value="{{ old('email', $userItem->email) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        @error('email') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Số điện thoại</label>
                        <input name="phone" value="{{ old('phone', $userItem->phone) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Vai trò</label>
                        <select name="role" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                            <option value="user" @selected(old('role', $userItem->role ?: 'user') === 'user')>Người dùng</option>
                            <option value="admin" @selected(old('role', $userItem->role) === 'admin')>Quản trị viên</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Địa chỉ</label>
                    <input name="address" value="{{ old('address', $userItem->address) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Trạng thái</label>
                        <input name="status" value="{{ old('status', $userItem->status) }}" placeholder="Hoạt động" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">{{ $isEdit ? 'Mật khẩu mới (để trống nếu không đổi)' : 'Mật khẩu' }}</label>
                        <input name="password" type="password" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        @error('password') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="rounded-2xl bg-[#10a37f] px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo người dùng' }}
                </button>
            </form>
        </div>
    </section>
@endsection
