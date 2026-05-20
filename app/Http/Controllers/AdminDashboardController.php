<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Comment;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $randomComments = Comment::inRandomOrder()
            ->take(2)
            ->get();
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalContents' => Song::count() + Album::count() + Artist::count() + Comment::count(),
            'randomComments' => $randomComments,
        ]);
    }
}
