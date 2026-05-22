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
        ],
        [
            // name
            'name.required' => 'Vui lòng nhập tên thể loại.',
            'name.string' => 'Tên thể loại không hợp lệ.',
            'name.max' => 'Tên thể loại không được vuien quá 255 ký tự.',

            // group_name
            'group_name.string' => 'Nhóm thể loại không hợp lệ.',
            'group_name.max' => 'Nhóm thể loại không được vuien quá 255 ký tự.',
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image_upload')) {
            $validated['image'] = ImageUpload::store($request->file('image_upload'), 'category_images');
        }

        unset($validated['image_upload']);

        Categories::create($validated);

        return redirect()->route('admin.categories.index')->with([
            'status' => 'success',
            'message' => 'Tạo thể loại thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        if (!Categories::where('id', $id)->exists()) {
            return view('admin.layouts.404', [
                'message' => 'Thể loại không tồn tại.'
            ]);
        }
        return view('admin.categories.form', [
            'category' => Categories::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (!Categories::where('id', $id)->exists()) {
            return redirect()->route('admin.categories.index')->with([
                'status' => 'error',
                'message' => 'Thể loại không tồn tại.',
            ]);
        }
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'group_name' => ['nullable', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
            'updated_at' => ['required'],
        ],
        [
            // name
            'name.required' => 'Vui lòng nhập tên thể loại.',
            'name.string' => 'Tên thể loại không hợp lệ.',
            'name.max' => 'Tên thể loại không được vuien quá 255 ký tự.',
            // group_name
            'group_name.string' => 'Nhóm thể loại không hợp lệ.',
            'group_name.max' => 'Nhóm thể loại không được vuien quá 255 ký tự.',
            // updated_at
            'updated_at.required' => 'Dữ liệu cập nhật không hợp lệ.',
        ]);

        $validated['status'] = $request->boolean('status');

        $category = Categories::findOrFail($id);

        // CHECK CONFLICT
        
        if ($request->updated_at != $category->updated_at->toDateTimeString()) {
            return redirect()->route('admin.categories.edit', $id)->with([
                'status' => 'error',
                'message' => 'Thể loại đã được cập nhật bởi người khác. Vui lòng tải lại trang và thử lại.',
            ]);
        }

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

        return redirect()->route('admin.categories.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật thể loại thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        if (!Categories::where('id', $id)->exists()) {
            return redirect()->route('admin.categories.index')->with([
                'status' => 'error',
                'message' => 'Thể loại không tồn tại.',
            ]);
        }
        $category = Categories::findOrFail($id);

        ImageUpload::delete($category->image);

        $category->delete();

        return redirect()->route('admin.categories.index')->with([
            'status' => 'success',
            'message' => 'Xóa thể loại thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        if (! $request->filled('ids')) {
            return redirect()->route('admin.categories.index')->with([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất một thể loại để xóa.',
            ]);
        }
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:categories,id'],
        ]);

        $categories = Categories::whereIn('id', $validated['ids'])->get();

        foreach ($categories as $category) {
            ImageUpload::delete($category->image);
            $category->delete();
        }

        return redirect()->route('admin.categories.index')->with([
            'status' => 'success',
            'message' => 'Xóa các thể loại đã chọn thành công.',
        ]);
    }
}
