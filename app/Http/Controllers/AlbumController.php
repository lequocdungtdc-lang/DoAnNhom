<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ActivityLog;

class AlbumController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        // Khởi tạo query
        $query = Album::latest();

        if (! empty($search) && mb_strlen($search) > 2) {
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
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image_upload')) {
            $validated['cover_image'] = ImageUpload::store($request->file('image_upload'), 'album_images');
        }

        unset($validated['image_upload']);

        $album = Album::create($validated);
        ActivityLog::create([
            'module' => 'Album',
            'action' => 'CREATE',
            'title' => $album->title,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('admin.albums.index')->with([
            'status' => 'success',
            'message' => 'Tạo album thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        if (! Album::where('id', $id)->exists()) {
            return view('admin.layouts.404', [
                'message' => 'Album không tồn tại.'
            ]);
        }

        return view('admin.albums.form', [
            'album' => Album::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (! Album::where('id', $id)->exists()) {
            return redirect()->route('admin.albums.index')->with([
                'status' => 'error',
                'message' => 'Album không tồn tại.',
            ]);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist_name' => ['required', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'status' => ['nullable', 'boolean'],
            'updated_at' => ['required'],
        ]);

        $validated['status'] = $request->boolean('status');

        $album = Album::findOrFail($id);

        if ($request->updated_at != $album->updated_at->toDateTimeString()) {
            return redirect()->route('admin.albums.edit', $id)->with([
                'status' => 'error',
                'message' => 'Album đã được cập nhật bởi người khác. Vui lòng tải lại trang và thử lại.',
            ]);
        }

        if ($request->hasFile('image_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('image_upload'),
                'album_images',
                'public',
                $album->cover_image,
            );

            if ($imagePath !== null) {
                $validated['cover_image'] = $imagePath;
            }
        }

        unset($validated['image_upload']);

        $album->update($validated);
        ActivityLog::create([
            'module' => 'Album',
            'action' => 'UPDATE',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.albums.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật album thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        if (! Album::where('id', $id)->exists()) {
            return redirect()->route('admin.albums.index')->with([
                'status' => 'error',
                'message' => 'Album không tồn tại.',
            ]);
        }

        $album = Album::findOrFail($id);
        ImageUpload::delete($album->cover_image);
        $album->delete();
        ActivityLog::create([
            'module' => 'Album',
            'action' => 'DELETE',
            'title' => $album->title,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.albums.index')->with([
            'status' => 'success',
            'message' => 'Xóa album thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        if (! $request->filled('ids')) {
            return redirect()->route('admin.albums.index')->with([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất một album để xóa.',
            ]);
        }

        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:albums,id'],
        ]);

        $albums = Album::whereIn('id', $validated['ids'])->get();

        foreach ($albums as $album) {
            ImageUpload::delete($album->cover_image);
            $album->delete();

            ActivityLog::create([
                'module' => 'Album',
                'action' => 'DELETE',
                'title' => $album->title,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('admin.albums.index')->with([
            'status' => 'success',
            'message' => 'Xóa các album đã chọn thành công.',
        ]);
    }
}
