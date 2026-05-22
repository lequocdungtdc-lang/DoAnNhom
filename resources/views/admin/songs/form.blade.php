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
                        <input name="title" value="{{ old('title', $song->title) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary">
                        @error('title') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Nghệ sĩ</label>
                        <select name="artist_id" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                            <option value="">Chọn nghệ sĩ</option>
                            @foreach ($artists as $artist)
                                <option value="{{ $artist->id }}" @selected((string) old('artist_id', $song->artist_id) === (string) $artist->id)>{{ $artist->name }}</option>
                            @endforeach
                        </select>
                        @error('artist_id') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Thể loại</label>
                        <select name="category_id" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                            <option value="">Chọn thể loại</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id', $song->category_id) === (string) $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Album</label>
                        <select name="album_id" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                            <option value="">Không thuộc album</option>
                            @foreach ($albums as $album)
                                <option value="{{ $album->id }}" @selected((string) old('album_id', $song->album_id) === (string) $album->id)>{{ $album->title }}</option>
                            @endforeach
                        </select>
                        @error('album_id') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Lượt nghe</label>
                        <input type="number" min="0" name="listen_count" value="{{ old('listen_count', $song->listen_count ?? 0) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary">
                        @error('listen_count') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    @include('admin.partials.audio-upload', [
                        'name' => 'audio_upload',
                        'label' => 'Tệp âm thanh MP3',
                        'value' => $song->audio_file,
                        'help' => $isEdit ? 'MP3 - tối đa 500MB. Bỏ trống nếu không đổi audio.' : 'MP3 - tối đa 500MB.',
                    ])
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image_upload',
                    'label' => 'Ảnh đại diện',
                    'value' => $song->thumbnail,
                ])

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Loại bài hát</label>
                        <select name="is_vip" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                            <option value="0" @selected((string) old('is_vip', (int) $song->is_vip) === '0')>Thường</option>
                            <option value="1" @selected((string) old('is_vip', (int) $song->is_vip) === '1')>VIP (Chỉ nghe khi có gói)</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Trạng thái</label>
                        <select name="status" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                            <option value="1" @selected((string) old('status', (int) $song->status) === '1')>Hiển thị</option>
                            <option value="0" @selected((string) old('status', (int) $song->status) === '0')>Ẩn</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="updated_at" value="{{ $song->updated_at }}">
                

                <button type="submit" class="rounded-2xl bg-admin-primary px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo bài hát' }}
                </button>
            </form>
        </div>
    </section>
@endsection
