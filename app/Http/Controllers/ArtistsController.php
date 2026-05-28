<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Categories;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ActivityLog;

class ArtistsController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Lấy từ khóa từ request
        $search = $request->query('search');

        // 2. Khởi tạo query với eager loading 'category'
        $query = Artist::with(['songs', 'category'])->latest();


        // 3. Kiểm tra điều kiện: không trống và độ dài > 2
        if (! empty($search) && mb_strlen($search) > 2) {
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
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image_upload')) {
            $validated['image'] = ImageUpload::store($request->file('image_upload'), 'artist_images');
        }

        unset($validated['image_upload']);

        $artist = Artist::create($validated);
        ActivityLog::create([
            'module' => 'Artist',
            'action' => 'CREATE',
            'title' => $artist->name,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('admin.artists.index')->with([
            'status' => 'success',
            'message' => 'Tạo nghệ sĩ thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        if (! Artist::where('id', $id)->exists()) {
            return view('admin.layouts.404', [
                'message' => 'Nghệ sĩ không tồn tại.'
            ]);
        }

        return view('admin.artists.form', [
            'artist' => Artist::findOrFail($id),
            'categories' => Categories::orderBy('name')->get(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (! Artist::where('id', $id)->exists()) {
            return redirect()->route('admin.artists.index')->with([
                'status' => 'error',
                'message' => 'Nghệ sĩ không tồn tại.',
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['nullable', 'boolean'],
            'updated_at' => ['required'],
        ]);

        $validated['status'] = $request->boolean('status');

        $artist = Artist::findOrFail($id);

        if ($request->updated_at != $artist->updated_at->toDateTimeString()) {
            return redirect()->route('admin.artists.edit', $id)->with([
                'status' => 'error',
                'message' => 'Nghệ sĩ đã được cập nhật bởi người khác. Vui lòng tải lại trang và thử lại.',
            ]);
        }

        if ($request->hasFile('image_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('image_upload'),
                'artist_images',
                'public',
                $artist->image,
            );

            if ($imagePath !== null) {
                $validated['image'] = $imagePath;
            }
        }

        unset($validated['image_upload']);

        $artist->update($validated);
        ActivityLog::create([
            'module' => 'Artist',
            'action' => 'UPDATE',
            'title' => $validated['name'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.artists.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật nghệ sĩ thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        if (! Artist::where('id', $id)->exists()) {
            return redirect()->route('admin.artists.index')->with([
                'status' => 'error',
                'message' => 'Nghệ sĩ không tồn tại.',
            ]);
        }

        $artist = Artist::findOrFail($id);
        ImageUpload::delete($artist->image);
        $artist->delete();
        ActivityLog::create([
            'module' => 'Artist',
            'action' => 'DELETE',
            'title' => $artist->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.artists.index')->with([
            'status' => 'success',
            'message' => 'Xóa nghệ sĩ thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        if (! $request->filled('ids')) {
            return redirect()->route('admin.artists.index')->with([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất một nghệ sĩ để xóa.',
            ]);
        }

        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:artists,id'],
        ]);

        $artists = Artist::whereIn('id', $validated['ids'])->get();

        foreach ($artists as $artist) {
            ImageUpload::delete($artist->image);
            $artist->delete();

            ActivityLog::create([
                'module' => 'Artist',
                'action' => 'DELETE',
                'title' => $artist->name,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('admin.artists.index')->with([
            'status' => 'success',
            'message' => 'Xóa các nghệ sĩ đã chọn thành công.',
        ]);
    }
}
