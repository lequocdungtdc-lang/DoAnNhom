@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="mx-auto max-w-4xl admin-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Album</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">{{ $isEdit ? 'Cập nhật album' : 'Tạo album mới' }}</h2>
                </div>
                <a href="{{ route('admin.albums.index') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">Quay lại</a>
            </div>

            <form action="{{ $isEdit ? route('admin.albums.update', $album->id) : route('admin.albums.store') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Tên album</label>
                        <input name="ten_album" value="{{ old('ten_album', $album->ten_album) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        @error('ten_album') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Nghệ sĩ</label>
                        <input name="nghe_si" value="{{ old('nghe_si', $album->nghe_si) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        @error('nghe_si') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Ảnh bìa (URL)</label>
                    <input name="anh_bia" value="{{ old('anh_bia', $album->anh_bia) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Trạng thái</label>
                    <select name="status" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        <option value="1" @selected((string) old('status', (int) $album->status) === '1')>Hiển thị</option>
                        <option value="0" @selected((string) old('status', (int) $album->status) === '0')>Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="rounded-2xl bg-[#10a37f] px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo album' }}
                </button>
            </form>
        </div>
    </section>
@endsection
