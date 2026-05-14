@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">

        <h1 class="text-4xl font-bold text-center mb-10 text-gray-800">Trang Chủ</h1>

        <!-- Tin Nổi Bật -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                🔥 Tin Nổi Bật
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredNews as $news)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all">
                    <div class="h-52 bg-gray-200 relative">
                        <img src="https://picsum.photos/id/{{ rand(1,100) }}/800/400" 
                             alt="{{ $news->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-5">
                        <span class="text-xs font-medium text-blue-600 bg-blue-100 px-3 py-1 rounded-full">
                            {{ $news->category ?? 'Tin tức' }}
                        </span>
                        <h3 class="font-bold text-lg mt-3 leading-tight">
                            <a href="{{ route('news.show', $news->slug) }}" class="hover:text-blue-600">
                                {{ $news->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mt-2 line-clamp-3">{{ $news->summary }}</p>
                        <p class="text-xs text-gray-500 mt-4">{{ $news->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tin Mới Nhất -->
        <div>
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                📰 Tin Tức Mới Nhất
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestNews as $news)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all">
                    <div class="h-48 bg-gray-200 relative">
                        <img src="https://picsum.photos/id/{{ rand(10,200) }}/800/400" 
                             alt="{{ $news->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold leading-tight">
                            <a href="{{ route('news.show', $news->slug) }}" class="hover:text-blue-600">
                                {{ $news->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $news->summary }}</p>
                        <p class="text-xs text-gray-500 mt-4">{{ $news->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection