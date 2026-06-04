@extends('web.master', ['title' => 'Nghệ sĩ'])

@php
    $fallbackCover = 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=600&q=80';
@endphp

@section('content')
    <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 shadow-2xl shadow-violet-950/30 backdrop-blur-xl sm:p-8">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Nghệ sĩ</p>
        <h1 class="mt-3 text-4xl font-extrabold leading-tight">Danh sách nghệ sĩ</h1>
        <p class="mt-3 max-w-2xl text-sm leading-6 text-violet-100/75">Chọn nghệ sĩ để mở trang phát riêng và nghe toàn bộ bài hát khả dụng.</p>
    </section>

    <section class="mt-8 rounded-[2rem] border border-white/10 bg-black/20 p-5 backdrop-blur-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Thư viện</p>
                <h2 class="mt-2 text-2xl font-bold">{{ $artists->total() }} nghệ sĩ</h2>
            </div>
        </div>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($artists as $artist)

                <a href="{{ route('artists.show', $artist['id']) }}" class="group flex items-center gap-4 rounded-2xl border border-white/10 bg-white/[0.05] p-4 transition hover:bg-white/10">
                    
                    <img src="{{ $artist['image'] ?? $fallbackCover }}" alt="{{ $artist['name'] }}" class="h-16 w-16 rounded-full object-cover">
                    <span class="min-w-0 flex-1">
                        <span class="block truncate font-semibold text-white group-hover:text-fuchsia-100">{{ $artist['name'] }}</span>
                        <span class="mt-1 block text-sm text-white/50">{{ $artist['songs_count'] }} bài hát</span>
                    </span>
                    <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-white/60 group-hover:border-fuchsia-300/50 group-hover:text-fuchsia-100">Mở</span>
                </a>
            @empty
                <div class="rounded-3xl border border-dashed border-white/15 p-8 text-center text-white/60">
                    Chưa có nghệ sĩ nào.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $artists->links() }}
        </div>
    </section>
@endsection
