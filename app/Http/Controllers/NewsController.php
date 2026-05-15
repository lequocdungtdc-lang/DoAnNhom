<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Danh sách tin tức
     */
    public function index(): View
    {
        $news = News::where('status', 'published')
                    ->latest()
                    ->paginate(9);

        return view('news.index', compact('news'));
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
}