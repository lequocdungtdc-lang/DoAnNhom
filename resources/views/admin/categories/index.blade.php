@extends('admin.master')

@section('content')
    <section class="py-4 md:py-6">
        <div class="admin-card">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Thể loại</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Quản lý thể loại</h2>
                </div>
                <div class="flex flex-col gap-3 md:flex-row md:items-center">
                    <form id="bulk-delete-categories-form" action="{{ route('admin.categories.bulk-delete') }}" method="POST" onsubmit="return confirm('Xóa các thể loại đã chọn?')">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="submit" form="bulk-delete-categories-form" class="rounded-2xl border border-red-400/20 px-4 py-3 text-sm font-semibold text-red-200 transition hover:bg-red-500/10">Xóa đã chọn</button>
                    <a href="{{ route('admin.categories.create') }}" class="rounded-2xl bg-admin-primary px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">Thêm thể loại</a>
                </div>
            </div>

            <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">
                <table class="min-w-full divide-y divide-white/8">
                    <thead class="bg-white/3">
                        <tr class="text-left text-sm text-[#8a93a3]">
                            <th class="px-4 py-3">
                                <input type="checkbox" data-check-all="category_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                            </th>
                            <th class="px-4 py-3">Tên thể loại</th>
                            <th class="px-4 py-3">Ảnh</th>
                            <th class="px-4 py-3">Nhóm</th>
                            <th class="px-4 py-3">Trạng thái</th>
                            <th class="px-4 py-3">Cập nhật</th>
                            <th class="px-4 py-3 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/8 bg-[#11141b]">
                        @forelse ($categories as $category)
                            <tr class="text-sm text-white">
                                <td class="px-4 py-4">
                                    <input form="bulk-delete-categories-form" type="checkbox" name="ids[]" value="{{ $category->id }}" data-check-item="category_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                                </td>
                                <td class="px-4 py-4">{{ $category->name }}</td>
                                <td class="px-4 py-4">
                                    @php
                                        $categoryImage = trim((string) $category->image);
                                        $categoryImageUrl = \App\Support\ImageUpload::url($categoryImage);
                                    @endphp

                                    @if ($categoryImageUrl)
                                        <img src="{{ $categoryImageUrl }}" alt="{{ $category->name }}" class="h-14 w-14 rounded-xl border border-white/10 object-cover">
                                    @else
                                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-white/10 text-xs text-[#8a93a3]">No img</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ $category->group_name ?: 'Chưa có' }}</td>
                                <td class="px-4 py-4">{{ $category->status ? 'Hiển thị' : 'Ẩn' }}</td>
                                <td class="px-4 py-4 text-[#a8b1bf]">{{ optional($category->updated_at)->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="rounded-xl border border-white/10 px-3 py-2 text-xs text-white transition hover:bg-white/5">Sửa</a>
                                        <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('Xóa thể loại này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl border border-red-400/20 px-3 py-2 text-xs text-red-200 transition hover:bg-red-500/10">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-sm text-[#8a93a3]">Chưa có thể loại nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
        <div class="my-3 grid gap-4 md:grid-cols-2">

        <article class="admin-card">
            <p class="text-sm text-[#8a93a3]">
                Tổng thể loại
            </p>

            <h3 class="mt-2 text-2xl font-bold text-white">
                {{ $totalCategories }}
            </h3>
        </article>

        <article class="admin-card">
            <p class="text-sm text-[#8a93a3]">
                Thể loại đang hoạt động
            </p>

            <h3 class="mt-2 text-2xl font-bold text-white">
                {{ $activeCategories }}
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
