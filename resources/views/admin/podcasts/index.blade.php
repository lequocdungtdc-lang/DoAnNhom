@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">
    @if ($mostViewedPodcast)

    <div class="mt-6 rounded-3xl border border-white/10 bg-white/[0.03] p-5">

        <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
            Podcast nổi bật
        </p>

        <div class="mt-4 flex items-center gap-4">

            @php
                $podcastImage = trim((string) $mostViewedPodcast->thumbnail);
                $podcastImageUrl = \App\Support\ImageUpload::url($podcastImage);
            @endphp

            @if ($podcastImageUrl)
                <img src="{{ $podcastImageUrl }}" alt="{{ $mostViewedPodcast->title }}" class="h-14 w-14 rounded-xl border border-white/10 object-cover">
            @else
                <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-white/10 text-xs text-[#8a93a3]">No img</span>
            @endif

            <div>

                <h3 class="text-lg font-semibold text-white">
                    {{ $mostViewedPodcast->title }}
                </h3>

                <p class="mt-1 text-sm text-[#8a93a3]">
                    {{ number_format($mostViewedPodcast->views) }} lượt nghe
                </p>

                <p class="mt-2 text-sm text-[#cfd5df] line-clamp-2">
                    {{ $mostViewedPodcast->description }}
                </p>

            </div>

        </div>

    </div>

    @endif
    <div class="admin-card my-4">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Podcast
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    Quản lý podcast
                </h2>
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                <form id="bulk-delete-podcasts-form" action="{{ route('admin.podcasts.bulk-delete') }}" method="POST" onsubmit="return confirm('Xóa các podcast đã chọn?')">
                    @csrf
                    @method('DELETE')
                </form>
                <button type="submit" form="bulk-delete-podcasts-form"
                    class="rounded-2xl border border-red-400/20 px-4 py-3 text-sm font-semibold text-red-200 transition hover:bg-red-500/10">
                    Xóa đã chọn
                </button>
                <a href="{{ route('admin.podcasts.create') }}"
                    class="rounded-2xl bg-admin-primary px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                    Thêm podcast
                </a>
            </div>

        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">

            <table class="min-w-full divide-y divide-white/8">

                <thead class="bg-white/[0.03]">
                    <tr class="text-left text-sm text-[#8a93a3]">
                        <th class="px-4 py-3">
                            <input type="checkbox" data-check-all="podcast_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                        </th>
                        <th class="px-4 py-3">Ảnh</th>
                        <th class="px-4 py-3">Tiêu đề</th>
                        <th class="px-4 py-3">File âm thanh</th>
                        <th class="px-4 py-3">Thời lượng</th>
                        <th class="px-4 py-3">Lượt nghe</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/8 bg-[#11141b]">

                    @forelse ($podcasts as $podcast)

                    <tr class="text-sm text-white">

                        <td class="px-4 py-4">
                            <input form="bulk-delete-podcasts-form" type="checkbox" name="ids[]" value="{{ $podcast->id }}" data-check-item="podcast_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                        </td>

                        <td class="px-4 py-4">
                            @php
                                $podcastImage = trim((string) $podcast->thumbnail);
                                $podcastImageUrl = \App\Support\ImageUpload::url($podcastImage);
                            @endphp

                            @if ($podcastImageUrl)
                                <img src="{{ $podcastImageUrl }}" alt="{{ $podcast->title }}" class="h-14 w-14 rounded-xl border border-white/10 object-cover">
                            @else
                                <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-white/10 text-xs text-[#8a93a3]">No img</span>
                            @endif
                        </td>

                        <td class="px-4 py-4">
                            {{ $podcast->title }}
                        </td>

                        <td class="px-4 py-4 text-[#a8b1bf]">
                            @php
                                $podcastAudio = trim((string) $podcast->audio_file);
                                $podcastAudioUrl = \App\Support\AudioUpload::url($podcastAudio);
                            @endphp

                            @if ($podcastAudioUrl)
                                <audio src="{{ $podcastAudioUrl }}" controls class="w-52"></audio>
                            @elseif ($podcastAudio !== '')
                                <span class="text-xs text-red-300">File không tồn tại</span>
                            @else
                                Chưa có
                            @endif
                        </td>

                        <td class="px-4 py-4 text-[#a8b1bf]">
                            {{ $podcast->duration ? $podcast->duration . ' giây' : '---' }}
                        </td>
                        <td class="px-4 py-4 text-[#a8b1bf]">
                            {{ number_format($podcast->views) }}
                        </td>
                        <td class="px-4 py-4">
                            {{ $podcast->status ? 'Hiển thị' : 'Ẩn' }}
                        </td>

                        <td class="px-4 py-4">

                            <div class="flex justify-end gap-2">

                                <a href="{{ route('admin.podcasts.edit', $podcast->id) }}"
                                    class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">
                                    Sửa
                                </a>

                                <form action="{{ route('admin.podcasts.delete', $podcast->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Xóa podcast này?')">

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
                        <td colspan="8"
                            class="px-4 py-10 text-center text-sm text-[#8a93a3]">
                            Chưa có podcast nào.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $podcasts->links() }}
        </div>

    </div>
    <div class="mt-2 grid gap-4 md:grid-cols-2">

        <article class="admin-card">
            <p class="text-sm text-[#8a93a3]">
                Podcast đang hiển thị
            </p>

            <h3 class="mt-2 text-2xl font-bold text-white">
                {{ $totalPodcasts }}
            </h3>
        </article>

        <article class="admin-card">
            <p class="text-sm text-[#8a93a3]">
                Tổng lượt nghe
            </p>

            <h3 class="mt-2 text-2xl font-bold text-white">
                {{ number_format($totalViews) }}
            </h3>
        </article>

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
