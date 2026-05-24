@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">
    <div class="mx-auto max-w-4xl admin-card">

        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">News</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">
                    {{ isset($news) ? 'Cập nhật tin tức' : 'Thêm tin tức mới' }}
                </h2>
            </div>

            <a href="{{ route('admin.news.index') }}"
                class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">
                Quay lại
            </a>
        </div>

        <form action="{{ isset($news) ? route('admin.news.update', $news->id) : route('admin.news.store') }}"
            method="POST" class="mt-8 space-y-5">
            @csrf

            @if(isset($news))
            @method('PUT')
            @endif

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Tiêu đề
                </label>

                <input type="text" name="title" value="{{ old('title', $news->title ?? '') }}"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]"
                    required>

                @error('title')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Danh mục
                </label>

                <input type="text" name="category" value="{{ old('category', $news->category ?? '') }}"
                    placeholder="Ví dụ: Công nghệ, Kinh tế..."
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">

                @error('category')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Tóm tắt
                </label>

                <textarea name="summary" rows="3"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]">{{ old('summary', $news->summary ?? '') }}</textarea>

                @error('summary')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Nội dung
                </label>

                <textarea name="content" rows="10"
                    class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-[#10a37f]"
                    required>{{ old('content', $news->content ?? '') }}</textarea>

                @error('content')
                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm text-[#cfd5df]">
                    Trạng thái
                </label>

                <select name="status"
                    class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-[#10a37f]">
                    <option value="1" @selected((string) old('status', $news->status ?? 1) === '1')>
                        Hiển thị
                    </option>

                    <option value="0" @selected((string) old('status', $news->status ?? 1) === '0')>
                        Ẩn
                    </option>
                </select>
            </div>

            <button type="submit"
                class="rounded-2xl bg-[#10a37f] px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                {{ isset($news) ? 'Lưu thay đổi' : 'Thêm tin tức' }}
            </button>
        </form>
    </div>
</section>
@endsection