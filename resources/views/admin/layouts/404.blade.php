@extends('admin.master')

@section('content')
<section class="py-6">
    <div class="mx-auto max-w-3xl">

        <div class="overflow-hidden rounded-3xl border border-red-400/10 bg-[#11141b] shadow-2xl">

            {{-- Header --}}
            <div class="border-b border-white/5 bg-red-500/5 px-8 py-6">
                <p class="text-xs uppercase tracking-[0.24em] text-red-300">
                    Error 404
                </p>

                <h1 class="mt-2 text-3xl font-semibold text-white">
                    Không tìm thấy dữ liệu
                </h1>
            </div>

            {{-- Content --}}
            <div class="px-8 py-10">

                <div class="flex flex-col items-center text-center">

                    {{-- Icon --}}
                    <div class="flex h-24 w-24 items-center justify-center rounded-3xl border border-red-400/10 bg-red-500/10 text-5xl">
                        🎵
                    </div>

                    <h2 class="mt-6 text-xl font-semibold text-white">
                        {{ $message ?? 'Dữ liệu không tồn tại.' }}
                    </h2>

                    <p class="mt-3 max-w-md text-sm leading-6 text-[#8a93a3]">
                        Bài hát bạn đang tìm kiếm có thể đã bị xóa hoặc đường dẫn không còn hợp lệ.
                    </p>

                    {{-- Buttons --}}
                    <div class="mt-8 flex flex-wrap justify-center gap-3">

                        <a href="{{ route('admin.songs.index') }}"
                           class="rounded-2xl bg-admin-primary px-5 py-3 text-sm font-semibold text-[#08110d] transition hover:brightness-110">
                            Quay lại danh sách
                        </a>

                        <a href="{{ url()->previous() }}"
                           class="rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/5">
                            Quay lại trang trước
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>
@endsection