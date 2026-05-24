<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Danh sách tin tức
     */
    public function index(): View
    {
        $news = News::latest()->paginate(9);

        return view('admin.news.index', [
    'news' => $news
]);
    }

    /**
     * Chi tiết tin tức
     */
    public function show($slug): View
    {
        $news = News::where('slug', $slug)->firstOrFail();
        
        // Tăng lượt xem
        $news->increment('views');

        // Tin liên quan
        $relatedNews = News::where('category', $news->category)
                            ->where('id', '!=', $news->id)
                            ->latest()
                            ->limit(4)
                            ->get();

        return view('news.show', compact('news', 'relatedNews'));
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