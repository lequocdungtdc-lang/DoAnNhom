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
            // Thay 'ten_album' bằng tên cột chính xác trong database của bạn
            $query->where('ten_album', 'like', '%' . $search . '%');
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
            'ten_album' => ['required', 'string', 'max:255'],
            'nghe_si' => ['required', 'string', 'max:255'],
            'anh_bia' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Album::create($validated);

        return redirect()->route('admin.albums.index')
            ->with('status', 'Tạo album thành công.');
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
            'ten_album' => ['required', 'string', 'max:255'],
            'nghe_si' => ['required', 'string', 'max:255'],
            'anh_bia' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Album::findOrFail($id)->update($validated);

        return redirect()->route('admin.albums.index')
            ->with('status', 'Cập nhật album thành công.');
    }

    public function delete(int $id): RedirectResponse
    {
        Album::findOrFail($id)->delete();

        return redirect()->route('admin.albums.index')
            ->with('status', 'Xóa album thành công.');
    }
}
