@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">
    <div class="mx-auto max-w-4xl admin-card">

        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Podcast</p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    {{ $isEdit ? 'Cập nhật podcast' : 'Tạo podcast mới' }}
                </h2>
            </div>

            <a href="{{ route('admin.podcasts.index') }}"
                class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">
                Quay lại
            </a>
        </div>

        <form action="{{ $isEdit ? route('admin.podcasts.update', $podcast->id) : route('admin.podcasts.store') }}"
            method="POST"
            class="mt-8 space-y-5">

            @csrf

            @if ($isEdit)
            @method('PUT')
            @endif

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Tiêu đề podcast
                </label>

                <input
                    name="title"
                    value="{{ old('title', $podcast->title) }}"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">

                @error('title')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Mô tả
                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">{{ old('description', $podcast->description) }}</textarea>

                @error('description')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 md:grid-cols-3">

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">
                        File âm thanh
                    </label>

                    <input
                        name="audio_file"
                        value="{{ old('audio_file', $podcast->audio_file) }}"
                        placeholder="podcasts/demo.mp3"
                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">

                    @error('audio_file')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">
                        Thời lượng (giây)
                    </label>

                    <input
                        type="number"
                        name="duration"
                        value="{{ old('duration', $podcast->duration) }}"
                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">

                    @error('duration')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">
                        Lượt nghe
                    </label>

                    <input
                        type="number"
                        name="views"
                        value="{{ old('views', $podcast->views ?? 0) }}"
                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">

                    @error('views')
                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Ảnh đại diện (URL)
                </label>

                <input
                    name="thumbnail"
                    value="{{ old('thumbnail', $podcast->thumbnail) }}"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">

                @error('thumbnail')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            @if ($podcast->thumbnail)
            <div>
                <img
                    src="{{ $podcast->thumbnail }}"
                    class="h-32 w-32 rounded-2xl object-cover border border-white/10">
            </div>
            @endif

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Trạng thái
                </label>

                <select
                    name="status"
                    class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                    <option value="1" @selected((string) old('status', (int) $podcast->status) === '1')>
                        Hiển thị
                    </option>

                    <option value="0" @selected((string) old('status', (int) $podcast->status) === '0')>
                        Ẩn
                    </option>
                </select>
            </div>

            <button
                type="submit"
                class="rounded-2xl bg-[#10a37f] px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                {{ $isEdit ? 'Lưu thay đổi' : 'Tạo podcast' }}
            </button>

        </form>
    </div>
</section>
@endsection