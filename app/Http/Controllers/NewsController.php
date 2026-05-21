<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;

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

        $news = News::latest()->paginate(9);

        return view('admin.news.index', [
    'news' => $news
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
    public function create()
    {
        return view('admin.news.create');
    }
    /**
     * Form sửa tin tức
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);

        return view('admin.news.edit', compact('news'));
    }

    /**
     * Cập nhật tin tức
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $news->update($request->all());

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Cập nhật tin tức thành công');
    }

    /**
     * Xóa tin tức
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Xóa thành công');
    }
    public function store(Request $request)
    {
        $slug = \Illuminate\Support\Str::slug($request->title);

        $count = News::where('slug', 'LIKE', "{$slug}%")->count();

        if ($count > 0) {
        $slug = $slug . '-' . ($count + 1);
        }

            News::create([
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category,
                'status' => $request->status ?? 1,
                'slug' => $slug,
        ]);

        return redirect()->route('admin.news.index')
                ->with('success', 'Thêm tin tức thành công');
}
}