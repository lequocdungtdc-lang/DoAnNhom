@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="mx-auto max-w-4xl admin-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Bài hát</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">{{ $isEdit ? 'Cập nhật bài hát' : 'Tạo bài hát mới' }}</h2>
                </div>
                <a href="{{ route('admin.songs.index') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">Quay lại</a>
            </div>

            <form action="{{ $isEdit ? route('admin.songs.update', $song->id) : route('admin.songs.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-5">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Tên bài hát</label>
                        <input name="tenbaihat" value="{{ old('tenbaihat', $song->tenbaihat) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary">
                        @error('tenbaihat') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Nghệ sĩ</label>
                        <select name="nghesi" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                            <option value="">Chọn nghệ sĩ</option>
                            @foreach ($artists as $artist)
                                <option value="{{ $artist->id }}" @selected((string) old('nghesi', $song->nghesi) === (string) $artist->id)>{{ $artist->name_artist }}</option>
                            @endforeach
                        </select>
                        @error('nghesi') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Thể loại</label>
                        <select name="theloai" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                            <option value="">Chọn thể loại</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('theloai', $song->theloai) === (string) $category->id)>{{ $category->tentheloai }}</option>
                            @endforeach
                        </select>
                        @error('theloai') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    @include('admin.partials.audio-upload', [
                        'name' => 'audio_upload',
                        'label' => 'Tệp âm thanh MP3',
                        'value' => $song->file_amthanh,
                        'help' => $isEdit ? 'MP3 - tối đa 500MB. Bỏ trống nếu không đổi audio.' : 'MP3 - tối đa 500MB.',
                    ])
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image_upload',
                    'label' => 'Ảnh đại diện',
                    'value' => $song->anh_daidien,
                ])

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Trạng thái</label>
                    <select name="status" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                        <option value="1" @selected((string) old('status', (int) $song->status) === '1')>Hiển thị</option>
                        <option value="0" @selected((string) old('status', (int) $song->status) === '0')>Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="rounded-2xl bg-admin-primary px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo bài hát' }}
                </button>
            </form>
        </div>
    </section>
@endsection
