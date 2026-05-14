<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $newsList = News::latest()->paginate(10);
        return view('admin.news.index', compact('newsList'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'summary' => 'nullable|string',
            'category'=> 'nullable|string',
        ]);

        News::create([
            'title'    => $request->title,
            'slug'     => Str::slug($request->title),
            'content'  => $request->content,
            'summary'  => $request->summary,
            'category' => $request->category,
            'user_id'  => 1,           // sau này thay bằng auth()->id()
            'status'   => 'published',
        ]);

        return redirect()->route('admin.news.index')
                         ->with('success', '✅ Thêm tin tức thành công!');
    }
}