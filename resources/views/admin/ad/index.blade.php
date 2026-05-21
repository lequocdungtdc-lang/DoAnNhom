@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">

    <div class="admin-card">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Quảng cáo
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    Quản lý quảng cáo
                </h2>
            </div>

            <a href="{{ route('admin.ads.create') }}"
               class="rounded-2xl bg-[#10a37f] px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                Thêm quảng cáo
            </a>

        </div>

        <!-- Thanh tìm kiếm Livewire của bạn được bọc gọn gàng ở đây -->
        <!-- <div class="mt-4">
            @livewire('search-ads')
        </div> -->

        <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">

            <table class="min-w-full divide-y divide-white/8">

                <thead class="bg-white/[0.03]">
                    <tr class="text-left text-sm text-[#8a93a3]">
                        <th class="px-4 py-3">Ảnh / Video</th>
                        <th class="px-4 py-3">Tên quảng cáo</th>
                        <th class="px-4 py-3">Link liên kết</th>
                        <th class="px-4 py-3">Mô tả</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/8 bg-[#11141b]">

                    @forelse ($ads as $ad)

                    <tr class="text-sm text-white">

                        <!-- Cột Ảnh/Video -->
                        <td class="px-4 py-4">
                            @if ($ad->media_type)
                                <img
                                    src="{{ asset('storage/' . $ad->media_type) }}"
                                    class="h-14 w-14 rounded-xl object-cover"
                                    alt="Ad Media"
                                >
                            @else
                                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/5 text-xs text-[#8a93a3]">
                                    No Media
                                </div>
                            @endif
                        </td>

                        <!-- Tên quảng cáo -->
                        <td class="px-4 py-4 font-semibold">
                            {{ $ad->name }}
                        </td>

                        <!-- Link liên kết -->
                        <td class="px-4 py-4 text-[#a8b1bf]">
                            @if($ad->link_url)
                                <a href="{{ $ad->link_url }}" target="_blank" class="hover:underline text-blue-400">
                                    {{ Str::limit($ad->link_url, 30) }}
                                </a>
                            @else
                                <span class="text-white/20">---</span>
                            @endif
                        </td>

                        <!-- Mô tả ngắn -->
                        <td class="px-4 py-4 text-[#a8b1bf]">
                            {{ Str::limit($ad->description, 40) }}
                        </td>

                        <!-- Trạng thái Bật/Tắt (is_active) -->
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $ad->is_active ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                                {{ $ad->is_active ? 'Đang hiển thị' : 'Đang ẩn' }}
                            </span>
                        </td>

                        <!-- Thao tác Sửa / Xóa -->
                        <td class="px-4 py-4">

                            <div class="flex justify-end gap-2">

                                <a href="{{ route('admin.ads.edit', $ad->id) }}"
                                   class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">
                                    Sửa
                                </a>

                                <form action="{{ route('admin.ads.destroy', $ad->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa quảng cáo này?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-xl border border-red-400/20 px-3 py-2 text-xs text-red-200 transition hover:bg-red-500/10">
                                        Xóa
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6"
                            class="px-4 py-10 text-center text-sm text-[#8a93a3]">
                            Chưa có quảng cáo nào.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Phân trang danh sách quảng cáo -->
        <div class="mt-4">
            {{ $ads->links() }}
        </div>

    </div>

    <!-- Tổng số lượng ở góc dưới -->
    <p class="mt-2 text-sm text-[#8a93a3]">
        Tổng số quảng cáo:
        <span class="font-semibold text-white">
            {{ $ads->total() }}
        </span>
    </p>

</section>
@endsection