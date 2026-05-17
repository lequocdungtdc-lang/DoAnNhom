@extends('admin.master')

@section('content')

<section class="py-4 md:py-6">

    <div class="admin-card">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">Subscription</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">Quản lý subscription</h2>
            </div>
            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                <form id="bulk-delete-subscriptions-form" action="{{ route('admin.subscriptions.bulk-delete') }}" method="POST" onsubmit="return confirm('Xóa các subscription đã chọn?')">
                    @csrf
                    @method('DELETE')
                </form>
                <button type="submit" form="bulk-delete-subscriptions-form" class="rounded-2xl border border-red-400/20 px-4 py-3 text-sm font-semibold text-red-200 transition hover:bg-red-500/10">Xóa đã chọn</button>
                <a href="{{ route('admin.subscriptions.create') }}" class="rounded-2xl bg-[#10a37f] px-4 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">Thêm subscription</a>
            </div>
        </div>


        {{-- TABLE --}}
        <div class="my-6 overflow-hidden rounded-3xl border border-white/8">

            <table class="min-w-full divide-y divide-white/8">
                <thead class="bg-white/[0.03]">
                    <tr class="text-left text-sm text-[#8a93a3]">

                        <th class="px-4 py-4">
                            <input type="checkbox" data-check-all="subscription_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                        </th>
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

                        <td class="px-4 py-4">
                            <input form="bulk-delete-subscriptions-form" type="checkbox" name="ids[]" value="{{ $subscription->id }}" data-check-item="subscription_ids" class="h-4 w-4 rounded border-white/10 bg-white/5">
                        </td>
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

                        <td colspan="9"
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
    <div class="my-5 grid gap-4 md:grid-cols-2">



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
    <!-- Biểu đồ doanh thu -->
    <div class="admin-card mb-6">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Revenue Analytics
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    Biểu đồ doanh thu theo tháng
                </h2>
            </div>

        </div>

        <div class="mt-6 h-[400px]">

            <canvas id="revenueChart"></canvas>

        </div>

    </div>
    <!-- Bảng doanh thu theo tháng -->
    <div class="admin-card mb-6">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                    Revenue Analytics
                </p>

                <h2 class="mt-2 text-2xl font-semibold text-white">
                    Doanh thu theo tháng
                </h2>
            </div>

        </div>

        <div class="mt-6 overflow-x-auto">

            <table class="w-full">

                <thead class="text-left text-sm text-[#7f8898]">

                    <tr>
                        <th class="py-3">Tháng</th>
                        <th class="py-3">Doanh thu</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($monthlyRevenue as $item)

                    <tr class="border-t border-white/5 text-white">

                        <td class="py-4">
                            Tháng {{ $item->month }}
                        </td>

                        <td class="py-4 font-semibold text-emerald-400">
                            {{ number_format($item->revenue) }}đ
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json($chartLabels),

            datasets: [{

                label: 'Doanh thu',

                data: @json($chartRevenue),

                borderWidth: 2,

                borderRadius: 12,

                backgroundColor: 'rgba(16, 163, 127, 0.5)',

                borderColor: '#10a37f',

                hoverBackgroundColor: '#10a37f',
            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    labels: {
                        color: '#ffffff'
                    }
                }
            },

            scales: {

                x: {

                    ticks: {
                        color: '#cfd5df'
                    },

                    grid: {
                        color: 'rgba(255,255,255,0.05)'
                    }
                },

                y: {

                    ticks: {

                        color: '#cfd5df',

                        callback: function(value) {
                            return value.toLocaleString() + 'đ';
                        }
                    },

                    grid: {
                        color: 'rgba(255,255,255,0.05)'
                    }
                }
            }
        }
    });
</script>
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