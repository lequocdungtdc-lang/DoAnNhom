<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Trang chủ - Hiển thị trang mặc định Laravel
     */
    public function index(): View
    {
        return view('welcome');   // ← Dùng trang welcome mặc định của Laravel
    }
}