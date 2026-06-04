@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">

    <div class="admin-card my-4">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Comment
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    Quản lý comment
                </h2>
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:items-center">

                <form
                    id="bulk-delete-comments-form"
                    action="{{ route('admin.comments.bulk-delete') }}"
                    method="POST"
                    onsubmit="return confirm('Xóa các comment đã chọn?')">

                    @csrf
                    @method('DELETE')

                </form>

                <button
                    type="submit"
                    form="bulk-delete-comments-form"
                    class="rounded-2xl border border-red-400/20 px-4 py-3 text-sm font-semibold text-red-200 transition hover:bg-red-500/10">

                    Xóa đã chọn
                </button>

                <a
                    href="{{ route('admin.comments.create') }}"
                    class="rounded-2xl bg-[#10a37f] px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">

                    Thêm comment
                </a>

            </div>

        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">

            <table class="min-w-full divide-y divide-white/8">

                <thead class="bg-white/[0.03]">
                    <tr class="text-left text-sm text-[#8a93a3]">

                        <th class="px-4 py-3">
                            <input
                                type="checkbox"
                                data-check-all="comment_ids"
                                class="h-4 w-4 rounded border-white/10 bg-white/5">
                        </th>

                        <th class="px-4 py-3">Người dùng</th>
                        <th class="px-4 py-3">Tin tức</th>
                        <th class="px-4 py-3">Nội dung</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-white/8 bg-[#11141b]">

                    @forelse ($comments as $comment)

                    <tr class="text-sm text-white">

                        <td class="px-4 py-4">
                            <input
                                form="bulk-delete-comments-form"
                                type="checkbox"
                                name="ids[]"
                                value="{{ $comment->id }}"
                                data-check-item="comment_ids"
                                class="h-4 w-4 rounded border-white/10 bg-white/5">
                        </td>

                        <td class="px-4 py-4">
                            {{ $comment->user->fullname ?? '---' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $comment->news->title ?? '---' }}
                        </td>

                        <td class="px-4 py-4 text-[#a8b1bf] max-w-[300px]">
                            {{ $comment->content }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $comment->status ? 'Hiển thị' : 'Ẩn' }}
                        </td>

                        <td class="px-4 py-4">

                            <div class="flex justify-end gap-2">

                                <a
                                    href="{{ route('admin.comments.edit', $comment->id) }}"
                                    class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">

                                    Sửa
                                </a>

                                <form
                                    action="{{ route('admin.comments.delete', $comment->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Xóa comment này?')">

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

                            Chưa có comment nào.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $comments->links() }}
        </div>

    </div>

    <div class="mt-2 grid gap-4 md:grid-cols-3">

        <article class="admin-card">
            <p class="text-sm text-[#8a93a3]">
                Tổng comment
            </p>

            <h3 class="mt-2 text-2xl font-bold text-white">
                {{ $totalComments }}
            </h3>
        </article>

        <article class="admin-card">
            <p class="text-sm text-[#8a93a3]">
                Comment hiển thị
            </p>

            <h3 class="mt-2 text-2xl font-bold text-white">
                {{ $activeComments }}
            </h3>
        </article>

        <article class="admin-card">
            <p class="text-sm text-[#8a93a3]">
                Comment mới nhất
            </p>

            <h3 class="mt-2 text-sm font-bold text-white">
                {{ Str::limit($latestComment?->content, 40) }}
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