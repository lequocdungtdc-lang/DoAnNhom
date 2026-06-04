@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="admin-card">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Album</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Quản lý album</h2>
                </div>
                <div class="flex flex-col gap-3 md:flex-row md:items-center">
                    <form id="bulk-delete-albums-form" action="{{ route('admin.albums.bulk-delete') }}" method="POST" onsubmit="return confirm('Xóa các album đã chọn?')">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="submit" form="bulk-delete-albums-form" class="rounded-2xl border border-red-400/20 px-4 py-3 text-sm font-semibold text-red-200 transition hover:bg-red-500/10">Xóa đã chọn</button>
                    <a href="{{ route('admin.albums.create') }}" class="rounded-2xl bg-admin-primary px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">Thêm album</a>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">
                <table class="min-w-full divide-y divide-white/8">
                    <thead class="bg-white/[0.03]">
                        <tr class="text-left text-sm text-[#8a93a3]">
                            <th class="px-4 py-3">
                                <input type="checkbox" data-check-all="album_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                            </th>
                            <th class="px-4 py-3">Ảnh</th>
                            <th class="px-4 py-3">Tên album</th>
                            <th class="px-4 py-3">Nghệ sĩ</th>
                            <th class="px-4 py-3">Trạng thái</th>
                            <th class="px-4 py-3">Cập nhật</th>
                            <th class="px-4 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/8 bg-[#11141b]">
                        @forelse ($albums as $album)
                            <tr class="text-sm text-white">
                                <td class="px-4 py-4">
                                    <input form="bulk-delete-albums-form" type="checkbox" name="ids[]" value="{{ $album->id }}" data-check-item="album_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                                </td>
                                <td class="px-4 py-4">
                                    @php
                                        $albumImage = trim((string) $album->cover_image);
                                        $albumImageUrl = \App\Support\ImageUpload::url($albumImage);
                                    @endphp

                                    @if ($albumImageUrl)
                                        <img src="{{ $albumImageUrl }}" alt="{{ $album->title }}" class="h-14 w-14 rounded-xl border border-white/10 object-cover">
                                    @else
                                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-white/10 text-xs text-[#8a93a3]">No img</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">{{ $album->title }}</td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ $album->artist_name }}</td>
                                <td class="px-4 py-4">{{ $album->status ? 'Hiển thị' : 'Ẩn' }}</td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ optional($album->updated_at)->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.albums.edit', $album->id) }}" class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">Sửa</a>
                                        <form action="{{ route('admin.albums.delete', $album->id) }}" method="POST" onsubmit="return confirm('Xóa album này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl border border-red-400/20 px-3 py-2 text-xs text-red-200 transition hover:bg-red-500/10">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-sm text-[#8a93a3]">Chưa có album nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $albums->links() }}
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
