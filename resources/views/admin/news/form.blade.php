@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="mx-auto max-w-4xl admin-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Tin tức</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">{{ $isEdit ? 'Cập nhật tin tức' : 'Tạo tin tức mới' }}</h2>
                </div>
                <a href="{{ route('admin.news.index') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">Quay lại</a>
            </div>

            <form action="{{ $isEdit ? route('admin.news.update', $news->id) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-5">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Tiêu đề</label>
                    <input name="title" value="{{ old('title', $news->title) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary" required>
                    @error('title') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Danh mục</label>
                        <input name="category" value="{{ old('category', $news->category) }}" placeholder="Ví dụ: Công nghệ, Kinh tế..." class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary">
                        @error('category') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm text-[#cfd5df]">Trạng thái</label>
                        <select name="status" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                            <option value="published" @selected(old('status', $news->status) === 'published')>Đã xuất bản</option>
                            <option value="draft" @selected(old('status', $news->status) === 'draft')>Nháp</option>
                            <option value="archived" @selected(old('status', $news->status) === 'archived')>Lưu trữ</option>
                        </select>
                    </div>
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image_upload',
                    'label' => 'Ảnh đại diện',
                    'value' => $news->image,
                ])

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Tóm tắt</label>
                    <textarea name="summary" rows="3" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary">{{ old('summary', $news->summary) }}</textarea>
                    @error('summary') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Nội dung</label>
                    <textarea name="content" rows="10" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary" required>{{ old('content', $news->content) }}</textarea>
                    @error('content') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <input type="hidden" name="updated_at" value="{{ $news->updated_at }}">

                <button type="submit" class="rounded-2xl bg-admin-primary px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo tin tức' }}
                </button>
            </form>
        </div>
    </section>
@endsection
