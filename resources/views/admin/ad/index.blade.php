@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="admin-card">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Quảng cáo</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Quản lý quảng cáo</h2>
                </div>
                <div class="flex flex-col gap-3 md:flex-row md:items-center">
                    <form id="bulk-delete-ads-form" action="{{ route('admin.ads.bulk-delete') }}" method="POST" onsubmit="return confirm('Xóa các quảng cáo đã chọn?')">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="submit" form="bulk-delete-ads-form" class="rounded-2xl border border-red-400/20 px-4 py-3 text-sm font-semibold text-red-200 transition hover:bg-red-500/10">Xóa đã chọn</button>
                    <a href="{{ route('admin.ads.create') }}" class="rounded-2xl bg-admin-primary px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">Thêm quảng cáo</a>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">
                <table class="min-w-full divide-y divide-white/8">
                    <thead class="bg-white/3">
                        <tr class="text-left text-sm text-[#8a93a3]">
                            <th class="px-4 py-3">
                                <input type="checkbox" data-check-all="ads_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                            </th>
                            <th class="px-4 py-3">Tên quảng cáo</th>
                            <th class="px-4 py-3">Ảnh</th>
                            <th class="px-4 py-3">Liên kết</th>
                            <th class="px-4 py-3">Mô tả</th>
                            <th class="px-4 py-3">Trạng thái</th>
                            <th class="px-4 py-3">Cập nhật</th>
                            <th class="px-4 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/8 bg-[#11141b]">
                        @forelse ($ads as $ad)
                            <tr class="text-sm text-white">
                                <td class="px-4 py-4">
                                    <input form="bulk-delete-ads-form" type="checkbox" name="ids[]" value="{{ $ad->id }}" data-check-item="ads_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                                </td>
                                <td class="px-4 py-4">{{ $ad->name }}</td>
                                <td class="px-4 py-4">
                                    @php
                                        $adImage = trim((string) $ad->media_type);
                                        $adImageUrl = \App\Support\ImageUpload::url($adImage);
                                    @endphp
                                    @if ($adImageUrl)
                                        <img src="{{ $adImageUrl }}" alt="{{ $ad->name }}" class="h-14 w-14 rounded-xl border border-white/10 object-cover">
                                    @else
                                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-white/10 text-xs text-[#8a93a3]">No img</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-[#a8b1bf]">
                                    @if($ad->link_url)
                                        <a href="{{ $ad->link_url }}" target="_blank" class="text-blue-400 hover:underline">{{ \Illuminate\Support\Str::limit($ad->link_url, 30) }}</a>
                                    @else
                                        ---
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ \Illuminate\Support\Str::limit($ad->description, 40) }}</td>
                                <td class="px-4 py-4">{{ $ad->is_active ? 'Hiển thị' : 'Ẩn' }}</td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ optional($ad->updated_at)->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.ads.edit', $ad->id) }}" class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">Sửa</a>
                                        <form action="{{ route('admin.ads.delete', $ad->id) }}" method="POST" onsubmit="return confirm('Xóa quảng cáo này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl border border-red-400/20 px-3 py-2 text-xs text-red-200 transition hover:bg-red-500/10">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-sm text-[#8a93a3]">Chưa có quảng cáo nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $ads->links() }}
            </div>
        </div>
    </section>
    <script>
        document.querySelectorAll('[data-check-all]').forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                document.querySelectorAll(`[data-check-item="${checkbox.dataset.checkAll}"]`).forEach((item) => {
                    item.checked = checkbox.checked;
                });
            });
        });
    </script>
@endsection
