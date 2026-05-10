<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Song;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SongController extends Controller
{
    public function index(): View
    {
        return view('admin.songs.index', [
            'songs' => Song::latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.songs.form', [
            'song' => new Song(),
            'categories' => Categories::orderBy('tentheloai')->get(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tenbaihat' => ['required', 'string', 'max:255'],
            'nghesi' => ['nullable', 'integer'],
            'theloai' => ['required', 'exists:categories,id'],
            'file_amthanh' => ['required', 'string', 'max:255'],
            'anh_daidien' => ['nullable', 'string', 'max:255'],
        ]);

        Song::create($validated);

        return redirect()->route('admin.songs.index')
            ->with('status', 'Tạo bài hát thành công.');
    }

    public function edit(int $id): View
    {
        return view('admin.songs.form', [
            'song' => Song::findOrFail($id),
            'categories' => Categories::orderBy('tentheloai')->get(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'tenbaihat' => ['required', 'string', 'max:255'],
            'nghesi' => ['nullable', 'integer'],
            'theloai' => ['required', 'exists:categories,id'],
            'file_amthanh' => ['required', 'string', 'max:255'],
            'anh_daidien' => ['nullable', 'string', 'max:255'],
        ]);

        Song::findOrFail($id)->update($validated);

        return redirect()->route('admin.songs.index')
            ->with('status', 'Cập nhật bài hát thành công.');
    }

    public function delete(int $id): RedirectResponse
    {
        Song::findOrFail($id)->delete();

        return redirect()->route('admin.songs.index')
            ->with('status', 'Xóa bài hát thành công.');
    }
}
