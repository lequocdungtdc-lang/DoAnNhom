@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="mx-auto max-w-4xl admin-card">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Quảng cáo</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">{{ $isEdit ? 'Cập nhật quảng cáo' : 'Tạo quảng cáo mới' }}</h2>
                </div>
                <a href="{{ route('admin.ads.index') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm text-white transition hover:bg-white/5">Quay lại</a>
            </div>

            <form action="{{ $isEdit ? route('admin.ads.update', $ad->id) : route('admin.ads.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-5">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Tên quảng cáo</label>
                    <input name="name" value="{{ old('name', $ad->name) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary" required>
                    @error('name') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                @include('admin.partials.image-upload', [
                    'name' => 'image_upload',
                    'label' => 'Ảnh quảng cáo',
                    'value' => $ad->image,
                ])

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Liên kết</label>
                    <input name="link_url" value="{{ old('link_url', $ad->link_url) }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary" required>
                    @error('link_url') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Mô tả</label>
                    <textarea name="description" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-admin-primary">{{ old('description', $ad->description) }}</textarea>
                </div>

                <div>
                    <label class="mb-2 block text-sm text-[#cfd5df]">Trạng thái</label>
                    <select name="is_active" class="w-full rounded-2xl border border-white/10 bg-[#13161d] px-4 py-3 text-white outline-none focus:border-admin-primary">
                        <option value="1" @selected((string) old('is_active', (int) $ad->is_active) === '1')>Hiển thị</option>
                        <option value="0" @selected((string) old('is_active', (int) $ad->is_active) === '0')>Ẩn</option>
                    </select>
                </div>

                <input type="hidden" name="updated_at" value="{{ $ad->updated_at }}">

                <button type="submit" class="rounded-2xl bg-admin-primary px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    {{ $isEdit ? 'Lưu thay đổi' : 'Tạo quảng cáo' }}
                </button>
            </form>
        </div>
    </section>
@endsection
