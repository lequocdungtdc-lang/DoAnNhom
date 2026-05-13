@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">
    <div class="admin-card">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Bài hát</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">Quản lý bài hát</h2>
            </div>
            <a href="{{ route('admin.songs.create') }}" class="rounded-2xl bg-[#10a37f] px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">Thêm bài hát</a>
        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">
            <table class="min-w-full divide-y divide-white/8">
                <thead class="bg-white/[0.03]">
                    <tr class="text-left text-sm text-[#8a93a3]">
                        <th class="px-4 py-3">Tên bài hát</th>
                        <th class="px-4 py-3">Nghệ sĩ</th>
                        <th class="px-4 py-3">Thể loại</th>
                        <th class="px-4 py-3">Tệp âm thanh</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/8 bg-[#11141b]">
                    @forelse ($songs as $song)
                    <tr class="text-sm text-white">
                        <td class="px-4 py-4">{{ $song->tenbaihat }}</td>
                        <td class="px-4 py-4 text-[#a8b1bf]">{{ $song->artist?->name_artist ?: 'Chưa có' }}</td>
                        <td class="px-4 py-4 text-[#a8b1bf]">{{ $song->category?->tentheloai ?: 'Chưa có' }}</td>
                        <td class="px-4 py-4 text-[#a8b1bf]">{{ $song->file_amthanh }}</td>
                        <td class="px-4 py-4">{{ $song->status ? 'Hiển thị' : 'Ẩn' }}</td>
                        <td class="px-4 py-4">
                            <div class="flex justify-end gap-2">

                                <a href="{{ route('admin.songs.edit', $song->id) }}"
                                    class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">
                                    Sửa
                                </a>

                                <form action="{{ route('admin.songs.delete', $song->id) }}" method="POST" onsubmit="return confirm('Xóa bài hát này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-xl border border-red-400/20 px-3 py-2 text-xs text-red-200 transition hover:bg-red-500/10">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-[#8a93a3]">Chưa có bài hát nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $songs->links() }}
        </div>
    </div>
</section>
@endsection