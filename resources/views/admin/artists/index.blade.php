@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="admin-card">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Nghệ sĩ</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Quản lý nghệ sĩ</h2>
                </div>
                <a href="{{ route('admin.artists.create') }}" class="rounded-2xl bg-[#10a37f] px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">Thêm nghệ sĩ</a>
            </div>

            <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">
                <table class="min-w-full divide-y divide-white/8">
                    <thead class="bg-white/[0.03]">
                        <tr class="text-left text-sm text-[#8a93a3]">
                            <th class="px-4 py-3">Tên nghệ sĩ</th>
                            <th class="px-4 py-3">Thể loại</th>
                            <th class="px-4 py-3">Ảnh đại diện</th>
                            <th class="px-4 py-3">Trạng thái</th>
                            <th class="px-4 py-3">Cập nhật</th>
                            <th class="px-4 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/8 bg-[#11141b]">
                        @forelse ($artists as $artist)
                            <tr class="text-sm text-white">
                                <td class="px-4 py-4">{{ $artist->name_artist }}</td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ $artist->category?->tentheloai ?: 'Chưa có' }}</td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ $artist->image_artist ?: 'Chưa có' }}</td>
                                <td class="px-4 py-4">{{ $artist->status ? 'Hiển thị' : 'Ẩn' }}</td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ optional($artist->updated_at)->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.artists.edit', $artist->id) }}" class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">Sửa</a>
                                        <form action="{{ route('admin.artists.delete', $artist->id) }}" method="POST" onsubmit="return confirm('Xóa nghệ sĩ này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl border border-red-400/20 px-3 py-2 text-xs text-red-200 transition hover:bg-red-500/10">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-[#8a93a3]">Chưa có nghệ sĩ nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $artists->links() }}
            </div>
        </div>
    </section>
@endsection
