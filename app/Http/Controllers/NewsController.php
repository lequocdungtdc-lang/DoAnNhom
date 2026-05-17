<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('status', 'published')
            ->latest()
            ->paginate(9);

        return view('web.news.index', [
            'news' => $news,
        ]);
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'summary' => 'nullable',
            'category' => 'nullable|string',
        ]);

        News::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'summary' => $request->summary,
            'category' => $request->category,
            'user_id' => 1, // sau này sẽ là auth()->id()
            'status' => 'published',
        ]);

        return redirect()->route('admin.news.index')->with([
            'status' => 'success',
            'message' => 'Thêm tin tức thành công!',
        ]);
    }

    public function show(string $slug)
    {
        $news = News::where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedNews = News::where('status', 'published')
            ->whereKeyNot($news->id)
            ->latest()
            ->take(3)
            ->get();

        return view('web.news.show', [
            'news' => $news,
            'relatedNews' => $relatedNews,
        ]);
    }
}