<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        // Khởi tạo query
        $query = Album::latest();

        // Kiểm tra nếu có từ khóa và độ dài > 3
        if (!empty($search) && mb_strlen($search) > 3) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return view('admin.albums.index', [
            'albums' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.albums.form', [
            'album' => new Album(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist_name' => ['required', 'string', 'max:255'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Album::create($validated);

        return redirect()->route('admin.albums.index')->with([
            'status' => 'success',
            'message' => 'Tạo album thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        return view('admin.albums.form', [
            'album' => Album::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist_name' => ['required', 'string', 'max:255'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Album::findOrFail($id)->update($validated);

        return redirect()->route('admin.albums.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật album thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        Album::findOrFail($id)->delete();

        return redirect()->route('admin.albums.index')->with([
            'status' => 'success',
            'message' => 'Xóa album thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:albums,id'],
        ]);

        Album::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.albums.index')->with([
            'status' => 'success',
            'message' => 'Xóa các album đã chọn thành công.',
        ]);
    }
}
