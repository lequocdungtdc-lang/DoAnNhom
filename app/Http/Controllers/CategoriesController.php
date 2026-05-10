<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Categories::latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.form', [
            'category' => new Categories(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tentheloai' => ['required', 'string', 'max:255'],
            'nhom' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Categories::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('status', 'Tạo thể loại thành công.');
    }

    public function edit(int $id): View
    {
        return view('admin.categories.form', [
            'category' => Categories::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'tentheloai' => ['required', 'string', 'max:255'],
            'nhom' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        $category = Categories::findOrFail($id);
        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('status', 'Cập nhật thể loại thành công.');
    }

    public function delete(int $id): RedirectResponse
    {
        Categories::findOrFail($id)->delete();

        return redirect()->route('admin.categories.index')
            ->with('status', 'Xóa thể loại thành công.');
    }
}
