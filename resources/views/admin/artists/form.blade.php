@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="mx-auto max-w-4xl admin-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Nghệ sĩ</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">{{ $isEdit ? 'Cập nhật nghệ sĩ' : 'Tạo nghệ sĩ mới' }}</h2>
                </div>
                <a href="{{ route('admin.artists.index') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">Quay lại</a>
            </div>

            <form action="{{ $isEdit ? route('admin.artists.update', $artist->id) : route('admin.artists.store') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Tên nghệ sĩ</label>
                        <input name="name_artist" value="{{ old('name_artist', $artist->name_artist) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        @error('name_artist') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Thể loại</label>
                        <select name="category_id" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                            <option value="">Chọn thể loại</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id', $artist->category_id) === (string) $category->id)>{{ $category->tentheloai }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Ảnh nghệ sĩ (URL)</label>
                    <input name="image_artist" value="{{ old('image_artist', $artist->image_artist) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Trạng thái</label>
                    <select name="status" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                        <option value="1" @selected((string) old('status', (int) $artist->status) === '1')>Hiển thị</option>
                        <option value="0" @selected((string) old('status', (int) $artist->status) === '0')>Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="rounded-2xl bg-[#10a37f] px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo nghệ sĩ' }}
                </button>
            </form>
        </div>
    </section>
@endsection
