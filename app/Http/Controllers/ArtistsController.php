<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Categories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtistsController extends Controller
{
    public function index(): View
    {
        return view('admin.artists.index', [
            'artists' => Artist::with('category')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.artists.form', [
            'artist' => new Artist(),
            'categories' => Categories::orderBy('tentheloai')->get(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_artist' => ['required', 'string', 'max:255'],
            'image_artist' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Artist::create($validated);

        return redirect()->route('admin.artists.index')
            ->with('status', 'Tạo nghệ sĩ thành công.');
    }

    public function edit(int $id): View
    {
        return view('admin.artists.form', [
            'artist' => Artist::findOrFail($id),
            'categories' => Categories::orderBy('tentheloai')->get(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name_artist' => ['required', 'string', 'max:255'],
            'image_artist' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Artist::findOrFail($id)->update($validated);

        return redirect()->route('admin.artists.index')
            ->with('status', 'Cập nhật nghệ sĩ thành công.');
    }

    public function delete(int $id): RedirectResponse
    {
        Artist::findOrFail($id)->delete();

        return redirect()->route('admin.artists.index')
            ->with('status', 'Xóa nghệ sĩ thành công.');
    }
}
