@extends('layouts.app')

@section('title', 'Tin Tức')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-10">📰 Tin Tức</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($news as $item)
        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
            <div class="h-56">
                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://picsum.photos/id/'.rand(1,200).'/800/400' }}" 
                     alt="{{ $item->title }}" 
                     class="w-full h-full object-cover">
            </div>
            <div class="p-5">
                <span class="inline-block px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full mb-3">
                    {{ $item->category ?? 'Tin tức' }}
                </span>
                
                <h3 class="font-bold text-lg leading-tight mb-3">
                    <a href="{{ route('news.show', $item->slug) }}" class="hover:text-blue-600">
                        {{ $item->title }}
                    </a>
                </h3>
                
                <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                    {{ $item->summary }}
                </p>
                
                <p class="text-xs text-gray-500">
                    {{ $item->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="mt-10 flex justify-center">
        {{ $news->links() }}
    </div>
</div>
@endsection