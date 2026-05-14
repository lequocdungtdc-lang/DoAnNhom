@extends('layouts.app')

@section('title', 'Thêm Tin Tức Mới')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8">Thêm Tin Tức Mới</h1>

    <form method="POST" action="{{ route('admin.news.store') }}" class="bg-white p-8 rounded-2xl shadow">
        @csrf

        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Tiêu đề</label>
            <input type="text" name="title" 
                   class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500"
                   required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Danh mục</label>
            <input type="text" name="category" 
                   class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500"
                   placeholder="Ví dụ: Công nghệ, Kinh tế, Xã hội...">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Tóm tắt</label>
            <textarea name="summary" rows="3"
                      class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500"></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Nội dung</label>
            <textarea name="content" rows="12"
                      class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:border-blue-500"
                      required></textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 font-medium">
                ✅ Thêm Tin Tức
            </button>
            <a href="{{ route('admin.news.index') }}" 
               class="bg-gray-500 text-white px-8 py-3 rounded-lg hover:bg-gray-600 font-medium">
                Quay lại
            </a>
        </div>
    </form>
</div>
@endsection