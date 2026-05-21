@extends('admin.master')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-gray-900 rounded-xl shadow">
    
    <h2 class="text-2xl font-bold text-white mb-6">
        Sửa Tin Tức
    </h2>

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="block text-white mb-2">
                Tiêu đề
            </label>

            <input type="text"
                   name="title"
                   value="{{ $news->title }}"
                   class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none">
        </div>

        <div class="mb-5">
            <label class="block text-white mb-2">
                Nội dung
            </label>

            <textarea name="content"
                      rows="8"
                      class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none">{{ $news->content }}</textarea>
        </div>

        <div class="mb-5">
            <label class="block text-white mb-2">
                Danh mục
            </label>

            <input type="text"
                   name="category"
                   value="{{ $news->category }}"
                   class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none">
        </div>

        <button type="submit"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
            Cập nhật
        </button>
    </form>
</div>
@endsection