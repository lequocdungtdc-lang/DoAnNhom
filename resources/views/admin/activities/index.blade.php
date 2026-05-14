@extends('admin.master')

@section('content')

<section class="py-4 md:py-6">

    <div class="admin-card">

        <div>
            <p class="text-xs uppercase tracking-[0.24em] text-[#7f8898]">
                Activity
            </p>

            <h2 class="mt-2 text-2xl font-semibold text-white">
                Lịch sử hoạt động
            </h2>
        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-white/8">

            <table class="min-w-full divide-y divide-white/8">

                <thead class="bg-white/[0.03]">
                    <tr class="text-left text-sm text-[#8a93a3]">
                        <th class="px-4 py-3">Module</th>
                        <th class="px-4 py-3">Hành động</th>
                        <th class="px-4 py-3">Tiêu đề</th>
                        <th class="px-4 py-3">Người thực hiện</th>
                        <th class="px-4 py-3">Thời gian</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/8 bg-[#11141b]">

                    @forelse ($logs as $log)

                    <tr class="text-sm text-white">

                        <td class="px-4 py-4">
                            {{ $log->module }}
                        </td>

                        <td class="px-4 py-4">

                            @if($log->action === 'CREATE')

                            <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-medium text-emerald-300">
                                CREATE
                            </span>

                            @elseif($log->action === 'UPDATE')

                            <span class="rounded-full bg-cyan-500/15 px-3 py-1 text-xs font-medium text-cyan-300">
                                UPDATE
                            </span>

                            @elseif($log->action === 'DELETE')

                            <span class="rounded-full bg-red-500/15 px-3 py-1 text-xs font-medium text-red-300">
                                DELETE
                            </span>

                            @else

                            <span class="rounded-full bg-gray-500/15 px-3 py-1 text-xs font-medium text-gray-300">
                                {{ $log->action }}
                            </span>

                            @endif

                        </td>

                        <td class="px-4 py-4 text-[#a8b1bf]">
                            {{ $log->title }}
                        </td>

                        <td class="px-4 py-4 text-[#a8b1bf]">
                            {{ $log->user?->fullname ?? 'Unknown' }}
                        </td>

                        <td class="px-4 py-4 text-[#a8b1bf]">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5"
                            class="px-4 py-10 text-center text-sm text-[#8a93a3]">
                            Chưa có lịch sử hoạt động.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>

    </div>

</section>

@endsection