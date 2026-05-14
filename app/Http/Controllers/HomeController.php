<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $latestNews = News::where('status', 'published')
            ->latest()
            ->limit(6)
            ->get();

        $featuredNews = News::where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();

        return view('web.index', compact('latestNews', 'featuredNews'));
    }
}