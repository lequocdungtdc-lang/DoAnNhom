@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">
     @if ($mostPopular)
    <div class="mt-5 rounded-3xl border border-white/10 bg-white/[0.03] p-5">

        <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
            Bài hát nổi bật
        </p>

        <div class="mt-4 flex items-center gap-4">

            {{-- <img
                src="{{ $mostPopular->anh_daidien }}"
                class="h-20 w-20 rounded-2xl object-cover border border-white/10"> --}}

                 @php
                    $songImage = trim((string) $mostPopular->anh_daidien);
                    $songImageUrl = \App\Support\ImageUpload::url($songImage);
                @endphp

                @if ($songImageUrl)
                    <img src="{{ $songImageUrl }}" alt="{{ $mostPopular->tenbaihat }}" class="h-14 w-14 rounded-xl border border-white/10 object-cover">
                @else
                    <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-white/10 text-xs text-[#8a93a3]">No img</span>
                @endif

            <div>

                <h3 class="text-lg font-semibold text-white">
                    {{ $mostPopular->tenbaihat }}
                </h3>

                <p class="mt-1 text-sm text-[#8a93a3]">
                    {{ number_format($mostPopular->luot_nghe) }} lượt nghe
                </p>

                <p class="mt-2 text-sm text-[#cfd5df] line-clamp-2">
                    {{ $mostPopular->artist?->name_artist ?? 'N/A' }}
                </p>

            </div>

        </div>

    </div>

    @endif
    <div class="admin-card my-5">
       <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Bài hát
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    Quản lý bài hát
                </h2>
            </div>

            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-end">

                {{-- Import Excel --}}
                <form action="{{ route('admin.songs.import') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="flex items-center gap-2">
                    @csrf

                    <input type="file"
                        name="file"
                        class="hidden"
                        id="importExcel"
                        onchange="this.form.submit()">

                    <label for="importExcel"
                        class="cursor-pointer rounded-2xl bg-blue-500 px-4 py-3 text-sm font-semibold text-white transition hover:brightness-110">
                        Import Excel
                    </label>
                </form>

                {{-- Export Excel --}}
                <a href="{{ route('admin.songs.export') }}"
                class="rounded-2xl bg-green-500 px-4 py-3 text-sm font-semibold text-white transition hover:brightness-110">
                    Export Excel
                </a>

                {{-- Thêm bài hát --}}
                <a href="{{ route('admin.songs.create') }}"
                class="rounded-2xl bg-admin-primary px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    Thêm bài hát
                </a>

            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">
            <table class="min-w-full divide-y divide-white/8">
                <thead class="bg-white/3">
                    <tr class="text-left text-sm text-[#8a93a3]">
                        <th class="px-4 py-3">Ảnh</th>
                        <th class="px-4 py-3">Tên bài hát</th>
                        <th class="px-4 py-3">Nghệ sĩ</th>
                        <th class="px-4 py-3">Thể loại</th>
                        <th class="px-4 py-3">Album</th>
                        <th class="px-4 py-3">Lượt nghe</th>
                        <th class="px-4 py-3">Tệp âm thanh</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/8 bg-[#11141b]">
                    @forelse ($songs as $song)
                    <tr class="text-sm text-white">
                        <td class="px-4 py-4">
                            @php
                                $songImage = trim((string) $song->anh_daidien);
                                $songImageUrl = \App\Support\ImageUpload::url($songImage);
                            @endphp

                            @if ($songImageUrl)
                                <img src="{{ $songImageUrl }}" alt="{{ $song->tenbaihat }}" class="h-14 w-14 rounded-xl border border-white/10 object-cover">
                            @else
                                <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-white/10 text-xs text-[#8a93a3]">No img</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">{{ $song->tenbaihat }}</td>
                        <td class="px-4 py-4 text-[#a8b1bf]">{{ $song->artist?->name_artist ?: 'Chưa có' }}</td>
                        <td class="px-4 py-4 text-[#a8b1bf]">{{ $song->category?->tentheloai ?: 'Chưa có' }}</td>
                        <td class="px-4 py-4 text-[#a8b1bf]">{{ $song->album?->ten_album ?: 'Chưa có' }}</td>
                        <td class="px-4 py-4 text-[#a8b1bf]">{{ number_format((int) $song->luot_nghe) }}</td>
                        <td class="px-4 py-4 text-[#a8b1bf]">
                            @php
                                $songAudio = trim((string) $song->file_amthanh);
                                $songAudioUrl = \App\Support\AudioUpload::url($songAudio);
                            @endphp

                            @if ($songAudioUrl)
                                <audio src="{{ $songAudioUrl }}" controls class="w-52"></audio>
                            @elseif ($songAudio !== '')
                                <span class="text-xs text-red-300">File không tồn tại</span>
                            @else
                                Chưa có
                            @endif
                        </td>
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
                        <td colspan="9" class="px-4 py-10 text-center text-sm text-[#8a93a3]">Chưa có bài hát nào.</td>
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