@extends('web.master', ['title' => 'Tin tức âm nhạc'])

@section('content')
    <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 shadow-2xl shadow-violet-950/30 backdrop-blur-xl md:p-8">
        <p class="text-xs font-bold uppercase tracking-[0.35em] text-fuchsia-200/80">News</p>
        <div class="mt-4 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-4xl font-extrabold leading-tight sm:text-5xl">Tin tức âm nhạc</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-violet-100/75">Cập nhật các bài viết, thông tin và câu chuyện mới trong hệ thống.</p>
            </div>
            <span class="rounded-full border border-white/10 px-4 py-3 text-sm text-white/70">{{ $news->total() }} bài viết</span>
        </div>
    </section>

    <section class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($news as $item)
            <article class="overflow-hidden rounded-[1.75rem] border border-white/10 bg-black/20 shadow-xl shadow-black/20 backdrop-blur-xl transition hover:-translate-y-1 hover:bg-white/[0.08]">
                <a href="{{ route('news.show', $item->slug) }}" class="block">
                    <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://picsum.photos/seed/news-'.$item->id.'/800/500' }}" alt="{{ $item->title }}" class="h-56 w-full object-cover">
                </a>

                <div class="p-5">
                    <span class="rounded-full bg-fuchsia-500/15 px-3 py-1 text-xs font-semibold text-fuchsia-100">{{ $item->category ?? 'Tin tức' }}</span>
                    <h2 class="mt-4 line-clamp-2 text-xl font-bold leading-snug">
                        <a href="{{ route('news.show', $item->slug) }}" class="transition hover:text-fuchsia-200">{{ $item->title }}</a>
                    </h2>
                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-white/60">{{ $item->summary }}</p>
                    <div class="mt-5 flex items-center justify-between text-xs text-white/45">
                        <span>{{ optional($item->created_at)->diffForHumans() }}</span>
                        <span>{{ number_format((int) $item->views) }} lượt xem</span>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-[2rem] border border-dashed border-white/15 p-10 text-center text-white/60">
                Chưa có tin tức nào được xuất bản.
            </div>
        @endforelse
    </section>

    <div class="mt-8">
        {{ $news->links() }}
    </div>
@endsection
