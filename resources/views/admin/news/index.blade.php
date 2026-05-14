@extends('layouts.app')

@section('title', 'Quản lý Tin Tức')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Quản lý Tin Tức</h1>
        <a href="{{ route('admin.news.create') }}" 
           class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
            + Thêm Tin Tức Mới
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Tiêu đề</th>
                    <th class="px-6 py-4 text-left">Danh mục</th>
                    <th class="px-6 py-4 text-center">Lượt xem</th>
                    <th class="px-6 py-4 text-center">Ngày đăng</th>
                    <th class="px-6 py-4 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($newsList as $news)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium">{{ $news->title }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                            {{ $news->category ?? 'Chưa phân loại' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">{{ $news->views }}</td>
                    <td class="px-6 py-4 text-center text-sm text-gray-500">
                        {{ $news->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="#" class="text-blue-600 hover:underline mr-3">Sửa</a>
                        <a href="#" class="text-red-600 hover:underline">Xóa</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        Chưa có tin tức nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $newsList->links() }}
    </div>
</div>
@endsection