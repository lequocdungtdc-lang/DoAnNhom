@extends('admin.master')

@section('content')
<section class="py-4 md:py-6">
    <div class="admin-card">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    News
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    Quản lý tin tức
                </h2>
            </div>

            <a href="{{ route('admin.news.create') }}"
                class="rounded-2xl bg-[#10a37f] px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                Thêm tin tức
            </a>
        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">
            <table class="min-w-full divide-y divide-white/8">

                <thead class="bg-white/[0.03]">
                    <tr class="text-left text-sm text-[#8a93a3]">
                        <th class="px-4 py-3">Tiêu đề</th>
                        <th class="px-4 py-3">Danh mục</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3">Cập nhật</th>
                        <th class="px-4 py-3 text-right">Thao tác</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/8 bg-[#11141b]">

                    @forelse ($news as $item)
                    <tr class="text-sm text-white">

                        <td class="px-4 py-4">
                            {{ $item->title }}
                        </td>

                        <td class="px-4 py-4 text-[#a8b1bf]">
                            {{ $item->category ?? 'Chưa có' }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $item->status ? 'Hiển thị' : 'Ẩn' }}
                        </td>

                        <td class="px-4 py-4 text-[#a8b1bf]">
                            {{ optional($item->updated_at)->format('d/m/Y H:i') }}
                        </td>

                        <td class="px-4 py-4">
                            <div class="flex items-center justify-end gap-3">

                                <a href="{{ route('admin.news.edit', $item->id) }}"
                                    class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">
                                    Sửa
                                </a>

                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="rounded-xl border border-white/10 px-3 py-2 text-xs text-red-500 transition hover:bg-white/5">
                                        Xóa
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-sm text-[#8a93a3]">
                            Chưa có tin tức nào.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $news->links() }}
        </div>

    </div>
</section>
@endsection