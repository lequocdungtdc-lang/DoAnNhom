@extends('web.master', ['title' => 'Danh sách phát của tôi'])

@php
    $fallbackCover = 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=600&q=80';
@endphp

@section('content')
    <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 shadow-2xl shadow-violet-950/30 backdrop-blur-xl sm:p-8">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">Thư viện cá nhân</p>
        <h1 class="mt-3 text-4xl font-extrabold">Danh sách phát của tôi</h1>
        <p class="mt-3 max-w-2xl text-sm leading-6 text-violet-100/75">
            Tạo playlist riêng, sau đó chọn bài hát ở trang khám phá hoặc trang nghệ sĩ để thêm vào danh sách phát.
        </p>
    </section>

    <section class="mt-8 grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)]">
        <div class="rounded-[2rem] border border-white/10 bg-black/20 p-5 backdrop-blur-xl">
            <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Tạo mới</p>
            <h2 class="mt-2 text-2xl font-bold">Playlist mới</h2>

            <form action="{{ route('playlists.store') }}" method="POST" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label class="mb-2 block text-sm text-white/70">Tên danh sách phát</label>
                    <input name="name" value="{{ old('name') }}" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-fuchsia-300">
                    @error('name') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm text-white/70">Mô tả</label>
                    <textarea name="description" rows="4" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none focus:border-fuchsia-300">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="rounded-full bg-white px-5 py-3 text-sm font-bold text-[#170f2f] transition hover:bg-violet-100">
                    Tạo danh sách phát
                </button>
            </form>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-white/[0.07] p-5 backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-violet-200/70">Playlist</p>
                    <h2 class="mt-2 text-2xl font-bold">{{ $playlists->total() }} danh sách</h2>
                </div>
                <a href="{{ route('home') }}" class="rounded-full border border-white/10 px-4 py-2 text-sm text-white/70 transition hover:bg-white/10">Thêm nhạc</a>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                @forelse ($playlists as $playlist)
                    <article class="rounded-2xl border border-white/10 bg-white/[0.05] p-4 transition hover:bg-white/10">
                        <a href="{{ route('playlists.show', $playlist) }}" class="block">
                            <div class="flex aspect-video items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-500/30 to-violet-500/30">
                                <span class="text-4xl font-black text-white/80">♪</span>
                            </div>
                            <h3 class="mt-4 truncate text-lg font-bold text-white">{{ $playlist->name }}</h3>
                            <p class="mt-1 line-clamp-2 text-sm text-white/55">{{ $playlist->description ?: 'Danh sách phát cá nhân' }}</p>
                            <p class="mt-3 text-sm text-white/45">{{ $playlist->songs_count }} bài hát</p>
                        </a>

                        <form action="{{ route('playlists.delete', $playlist) }}" method="POST" class="mt-4" onsubmit="return confirm('Xóa danh sách phát này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-red-300/20 px-4 py-2 text-xs font-semibold text-red-200 transition hover:bg-red-500/10">Xóa</button>
                        </form>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-white/15 p-8 text-center text-white/60 md:col-span-2">
                        Bạn chưa có danh sách phát nào. Tạo danh sách đầu tiên ở bên trái.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $playlists->links() }}
            </div>
        </div>
    </section>
@endsection
