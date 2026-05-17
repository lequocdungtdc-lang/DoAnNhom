<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    public function index(Request $request): View
    {
        // Tìm kiếm theo tên và nhóm
        $search = $request->query('search');
        $query = Categories::latest();
        if (! empty($search) && mb_strlen($search) > 2) {
            $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('group_name', 'like', '%' . $search . '%');
        }
        return view('admin.categories.index', [
            'categories' => $query->paginate(10)->withQueryString(),
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
            'name' => ['required', 'string', 'max:255'],
            'group_name' => ['nullable', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image_upload')) {
            $validated['image'] = ImageUpload::store($request->file('image_upload'), 'category_images');
        }

        unset($validated['image_upload']);

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
            'name' => ['required', 'string', 'max:255'],
            'group_name' => ['nullable', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        $category = Categories::findOrFail($id);

        if ($request->hasFile('image_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('image_upload'),
                'category_images',
                'public',
                $category->image,
            );

            if ($imagePath !== null) {
                $validated['image'] = $imagePath;
            }
        }

        unset($validated['image_upload']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('status', 'Cập nhật thể loại thành công.');
    }

    public function delete(int $id): RedirectResponse
    {
        $category = Categories::findOrFail($id);

        ImageUpload::delete($category->image);

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('status', 'Xóa thể loại thành công.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:categories,id'],
        ]);

        $categories = Categories::whereIn('id', $validated['ids'])->get();

        foreach ($categories as $category) {
            ImageUpload::delete($category->image);
            $category->delete();
        }

        return redirect()->route('admin.categories.index')
            ->with('status', 'Xóa các thể loại đã chọn thành công.');
    }
}
