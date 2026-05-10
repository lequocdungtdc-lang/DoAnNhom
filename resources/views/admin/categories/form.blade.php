@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="mx-auto max-w-4xl admin-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Thể loại</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">{{ $isEdit ? 'Cập nhật thể loại' : 'Tạo thể loại mới' }}</h2>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">Quay lại</a>
            </div>

            <form action="{{ $isEdit ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Tên thể loại</label>
                        <input name="tentheloai" value="{{ old('tentheloai', $category->tentheloai) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        @error('tentheloai') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Nhóm</label>
                        <input name="nhom" value="{{ old('nhom', $category->nhom) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Ảnh đại diện (URL)</label>
                    <input name="image" value="{{ old('image', $category->image) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Mô tả</label>
                    <textarea name="description" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">{{ old('description', $category->description) }}</textarea>
                </div>

                <label class="flex items-center gap-3 text-sm text-white">
                    <input type="checkbox" name="status" value="1" @checked(old('status', $category->status)) class="rounded border-white/10 bg-white/5 text-[#10a37f]">
                    Hiển thị thể loại
                </label>

                <button type="submit" class="rounded-2xl bg-[#10a37f] px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo thể loại' }}
                </button>
            </form>
        </div>
    </section>
@endsection
