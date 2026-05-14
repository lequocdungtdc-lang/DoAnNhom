@extends('admin.master')

@section('content')

<section class="py-4 md:py-6">

    <div class="admin-card">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Subscription</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">Quản lý subscription</h2>
            </div>
        </div>


        {{-- TABLE --}}
        <div class="my-6 overflow-hidden rounded-3xl border border-white/8">

            <table class="min-w-full divide-y divide-white/8">
                <thead class="bg-white/[0.03]">
                    <tr class="text-left text-sm text-[#8a93a3]">

                        <th class="px-4 py-4">ID</th>
                        <th class="px-4 py-4">Người dùng</th>
                        <th class="px-4 py-4">Gói</th>
                        <th class="px-4 py-4">Giá gói</th>
                        <th class="px-4 py-4">Ngày bắt đầu</th>
                        <th class="px-4 py-4">Ngày hết hạn</th>
                        <th class="px-4 py-4">Trạng thái</th>
                        <th class="px-4 py-4 text-right">Hành động</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-white/8 bg-[#11141b]">

                    @forelse($subscriptions as $subscription)

                    <tr class="text-sm text-white">

                        <td class="px-4 py-4">#{{ $subscription->id }}</td>
                        <td class="px-4 py-4">{{ $subscription->user->fullname ?? 'N/A' }}</td>
                        <td class="px-4 py-4">{{ $subscription->plan->name ?? 'N/A' }}</td>
                        <td class="px-4 py-4">
                            {{ $subscription->plan ? number_format($subscription->plan->price, 0, ',', '.') . ' đ' : 'N/A' }}
                        </td>
                        <td class="px-4 py-4">{{ $subscription->starts_at }}</td>
                        <td class="px-4 py-4">{{ $subscription->expires_at }}</td>
                        <td class="px-4 py-4">
                            @if($subscription->status)
                            <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs text-emerald-300">
                                Hoạt động
                            </span>
                            @else
                            <span class="rounded-full bg-red-500/15 px-3 py-1 text-xs text-red-300">
                                Ngưng
                            </span>
                            @endif
                        </td>

                        <td class="px-4 py-4">

                            <div class="flex justify-end gap-2">

                                <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}"
                                    class="rounded-xl border border-white/10 px-4 py-2 text-xs text-white transition hover:bg-white/5">
                                    Sửa
                                </a>

                                <form
                                    action="{{ route('admin.subscriptions.delete', $subscription->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        onclick="return confirm('Xóa subscription này?')"
                                        class="rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-2 text-xs text-red-300 transition hover:bg-red-500/20">
                                        Xóa
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7"
                            class="px-4 py-10 text-center text-sm text-[#7f8898]">
                            Chưa có subscription nào.
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $subscriptions->links() }}
        </div>

    </div>
    <div class="mt-2 grid gap-4 md:grid-cols-2">



        {{-- Tổng subscription --}}
        <article class="admin-card">

            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                Subscription
            </p>

            <p class="mt-4 text-3xl font-semibold text-white">
                {{ $totalSubscriptions }}
            </p>

            <p class="mt-2 text-sm text-[#8a93a3]">
                Tổng lượt đăng ký gói cước.
            </p>

        </article>

        {{-- Tổng doanh thu --}}
        <article class="admin-card">

            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                Doanh thu
            </p>

            <p class="mt-4 text-3xl font-semibold text-emerald-400">
                {{ number_format($totalRevenue) }}đ
            </p>

            <p class="mt-2 text-sm text-[#8a93a3]">
                Tổng doanh thu từ subscription.
            </p>

        </article>

    </div>
</section>

@endsection