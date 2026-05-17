<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Categories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtistsController extends Controller
{
   public function index(Request $request): View
    {
        // 1. Lấy từ khóa từ request
        $search = $request->query('search');

        // 2. Khởi tạo query với eager loading 'category'
        $query = Artist::with(['songs','category'])->latest();
        

        // 3. Kiểm tra điều kiện: không trống và độ dài > 2
        if (!empty($search) && mb_strlen($search) > 2) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // 4. Phân trang và giữ lại tham số tìm kiếm trên URL
        return view('admin.artists.index', [
            'artists' => $query->paginate(10)->withQueryString(),
        ]);
    }
    public function create(): View
    {
        return view('admin.artists.form', [
            'artist' => new Artist(),
            'categories' => Categories::orderBy('name')->get(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Artist::create($validated);

        return redirect()->route('admin.artists.index')->with([
            'status' => 'success',
            'message' => 'Tạo nghệ sĩ thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        return view('admin.artists.form', [
            'artist' => Artist::findOrFail($id),
            'categories' => Categories::orderBy('name')->get(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Artist::findOrFail($id)->update($validated);

        return redirect()->route('admin.artists.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật nghệ sĩ thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        Artist::findOrFail($id)->delete();

        return redirect()->route('admin.artists.index')->with([
            'status' => 'success',
            'message' => 'Xóa nghệ sĩ thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:artists,id'],
        ]);

        Artist::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('admin.artists.index')->with([
            'status' => 'success',
            'message' => 'Xóa các nghệ sĩ đã chọn thành công.',
        ]);
    }
}
