@extends('web.master', ['title' => $news->title])

@section('content')
<article class="mt-8 overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.08] shadow-2xl shadow-violet-950/30 backdrop-blur-xl">
    <img src="{{ $news->image ? asset('storage/'.$news->image) : 'https://picsum.photos/seed/news-'.$news->id.'/1200/520' }}" alt="{{ $news->title }}" class="h-72 w-full object-cover md:h-[420px]">

    <div class="p-6 md:p-10">
        <a href="{{ route('news.index') }}" class="text-sm font-semibold text-fuchsia-200 transition hover:text-white">← Quay lại tin tức</a>
        <div class="mt-5 flex flex-wrap items-center gap-3 text-sm text-white/55">
            <span class="rounded-full bg-fuchsia-500/15 px-3 py-1 text-xs font-semibold text-fuchsia-100">{{ $news->category ?? 'Tin tức' }}</span>
            <span>{{ optional($news->created_at)->format('d/m/Y') }}</span>
            <span>{{ number_format((int) $news->views) }} lượt xem</span>
        </div>

        <h1 class="mt-5 max-w-4xl text-4xl font-extrabold leading-tight md:text-5xl">{{ $news->title }}</h1>

        @if ($news->summary)
        <p class="mt-5 max-w-3xl text-lg leading-8 text-violet-100/75">{{ $news->summary }}</p>
        @endif

        <div class="prose prose-invert mt-8 max-w-none text-white/80">
            {!! $news->content !!}
            {{-- {!! nl2br(e($news->content)) !!} --}}
        </div>
    </div>


</article>
{{-- Form bình luận --}}
<div class="mt-8 rounded-[2rem] border border-white/10 bg-white/[0.08] p-6 backdrop-blur-xl">
    <h3 class="text-xl font-bold text-white">
        Viết bình luận
    </h3>

    @auth
    <form action="{{ route('web.comments.store') }}" method="POST" class="mt-5 space-y-4">
        @csrf

        {{-- ID bài viết --}}
        <input type="hidden" name="new_id" value="{{ $news->id }}">

        <textarea
            name="content"
            rows="4"
            placeholder="Chia sẻ cảm nghĩ của bạn về bài viết này..."
            class="w-full rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-white placeholder:text-white/40 focus:border-fuchsia-400 focus:outline-none">{{ old('content') }}</textarea>

        @error('content')
        <p class="text-sm text-red-400">
            {{ $message }}
        </p>
        @enderror

        <div class="flex justify-end">
            <button
                type="submit"
                class="rounded-full bg-gradient-to-r from-fuchsia-500 to-violet-500 px-6 py-3 text-sm font-semibold text-white transition hover:scale-105">
                Gửi bình luận
            </button>
        </div>
    </form>
    @else
    <div class="mt-4 rounded-2xl border border-yellow-400/20 bg-yellow-500/10 p-4 text-center">
        <p class="text-sm text-yellow-100">
            Bạn cần đăng nhập để bình luận.
        </p>

        <a href="{{ route('login') }}"
            class="mt-3 inline-block rounded-full bg-fuchsia-500 px-5 py-2 text-sm font-semibold text-white hover:bg-fuchsia-600">
            Đăng nhập
        </a>
    </div>
    @endauth
</div>

{{-- Danh sách bình luận --}}
<div class="mt-6 space-y-4">

    @foreach ($comments as $comment)

    <div class="rounded-2xl border border-white/8 bg-black/15 p-4">

        <div class="flex items-center gap-3">

            <img
                src="{{ $comment->user?->avatar ?? asset('images/default-avatar.png') }}"
                class="h-10 w-10 rounded-full object-cover">

            <div>
                <p class="text-sm font-medium text-white">
                    {{ $comment->user?->fullname ?? 'Người dùng không xác định' }}
                </p>

                <p class="text-xs text-[#7f8898]">
                    {{ $comment->created_at?->diffForHumans() }}
                </p>
            </div>

        </div>

        <p class="mt-3 text-sm text-[#8a93a3]">
            {{ $comment->content }}
        </p>

    </div>

    @endforeach

</div>
@if ($relatedNews->isNotEmpty())
<section class="mt-8">
    <h2 class="text-2xl font-bold">Tin liên quan</h2>
    <div class="mt-5 grid gap-5 md:grid-cols-3">
        @foreach ($relatedNews as $item)
        <a href="{{ route('news.show', $item->slug) }}" class="rounded-[1.5rem] border border-white/10 bg-black/20 p-4 transition hover:bg-white/[0.08]">
            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://picsum.photos/seed/news-'.$item->id.'/600/360' }}" alt="{{ $item->title }}" class="h-36 w-full rounded-2xl object-cover">
            <p class="mt-4 line-clamp-2 font-semibold">{{ $item->title }}</p>
            <p class="mt-2 text-xs text-white/45">{{ optional($item->created_at)->diffForHumans() }}</p>
        </a>
        @endforeach
    </div>
</section>
@endif
@endsection