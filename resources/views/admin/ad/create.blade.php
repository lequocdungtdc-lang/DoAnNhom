@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">

    <div class="admin-card">

        <!-- Tiêu đề trang -->
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between border-b border-white/8 pb-5">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Quảng cáo
                </p>
                <h2 class="mt-2 text-2xl font-semibold text-white">
                    Tạo quảng cáo mới
                </h2>
            </div>
            
            <a href="{{ route('admin.ads.index') }}" 
               class="rounded-xl border border-white/10 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-white/5">
                Quay lại danh sách
            </a>
        </div>

        <!-- Khung Form nhập liệu chuẩn Dark Mode -->
        <form action="{{ route('admin.ads.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf

            <!-- Tên quảng cáo -->
            <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-[#8a93a3] block">
                    Tên quảng cáo <span class="text-red-400">*</span>
                </label>
                <input type="text" 
                       id="name"
                       name="name" 
                       placeholder="Nhập tên chiến dịch quảng cáo..." 
                       value="{{ old('name') }}"
                       class="w-full rounded-2xl border border-white/8 bg-[#11141b] px-4 py-3.5 text-sm text-white placeholder-white/20 outline-none transition focus:border-[#10a37f]" 
                       required>
                @if ($errors->has('name'))
                    <p class="text-xs text-red-400 mt-1">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <!-- Tải lên Ảnh/Video -->
            <div class="space-y-2">
                <label for="media_type" class="text-sm font-medium text-[#8a93a3] block">
                    Ảnh hoặc Video quảng cáo <span class="text-red-400">*</span>
                </label>
                <div class="relative w-full rounded-2xl border border-white/8 bg-[#11141b] px-4 py-3 text-sm text-white transition focus-within:border-[#10a37f]">
                    <input type="file" 
                           id="media_type"
                           name="media_type" 
                           class="w-full opacity-100 cursor-pointer text-[#8a93a3] file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20" 
                           required>
                </div>
                @if ($errors->has('media_type'))
                    <p class="text-xs text-red-400 mt-1">{{ $errors->first('media_type') }}</p>
                @endif
            </div>

            <!-- Link liên kết -->
            <div class="space-y-2">
                <label for="link_url" class="text-sm font-medium text-[#8a93a3] block">
                    Đường dẫn liên kết (Link URL)
                </label>
                <input type="url" 
                       id="link_url"
                       name="link_url" 
                       placeholder="https://example.com/uu-dai" 
                       value="{{ old('link_url') }}"
                       class="w-full rounded-2xl border border-white/8 bg-[#11141b] px-4 py-3.5 text-sm text-white placeholder-white/20 outline-none transition focus:border-[#10a37f]">
                @if ($errors->has('link_url'))
                    <p class="text-xs text-red-400 mt-1">{{ $errors->first('link_url') }}</p>
                @endif
            </div>

            <!-- Trạng thái On/Off Switch -->
            <div class="flex items-center gap-3 bg-white/[0.02] p-4 rounded-2xl border border-white/4">
                <div class="flex h-5 items-center">
                    <input type="checkbox" 
                           id="is_active"
                           name="is_active" 
                           value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-white/10 bg-[#11141b] text-[#10a37f] focus:ring-[#10a37f] accent-[#10a37f]">
                </div>
                <div class="text-sm">
                    <label for="is_active" class="font-medium text-white cursor-pointer">Kích hoạt hiển thị</label>
                    <p class="text-xs text-[#7f8898]">Bật tùy chọn này để quảng cáo hiển thị ngay trên hệ thống.</p>
                </div>
            </div>

            <!-- Miêu tả quảng cáo -->
            <div class="space-y-2">
                <label for="description" class="text-sm font-medium text-[#8a93a3] block">
                    Mô tả ngắn quảng cáo
                </label>
                <textarea id="description"
                          name="description" 
                          rows="5" 
                          placeholder="Nhập nội dung hiển thị kèm theo quảng cáo (nếu có)..."
                          class="w-full rounded-2xl border border-white/8 bg-[#11141b] px-4 py-3.5 text-sm text-white placeholder-white/20 outline-none transition focus:border-[#10a37f] resize-none">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <p class="text-xs text-red-400 mt-1">{{ $errors->first('description') }}</p>
                @endif
            </div>

            <!-- Hệ thống nút hành động bấm -->
            <div class="flex items-center justify-end gap-3 border-t border-white/8 pt-5 mt-8">
                <a href="{{ route('admin.ads.index') }}" 
                   class="rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/5">
                    Hủy bỏ
                </a>
                
                <button type="submit" 
                        class="rounded-2xl bg-[#10a37f] px-6 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    Lưu quảng cáo
                </button>
            </div>

        </form>

    </div>

</section>
@endsection