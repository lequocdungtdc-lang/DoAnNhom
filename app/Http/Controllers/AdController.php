<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\ActivityLog;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Ad::latest();
        if (! empty($search) && mb_strlen($search) > 2) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        return view('admin.ads.index', [
            'ads' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.ads.form', [
            'ad' => new Ad(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'link_url' => ['required', 'url'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Vui lòng nhập tên quảng cáo.',
            'name.string' => 'Tên quảng cáo không hợp lệ.',
            'name.max' => 'Tên quảng cáo không được vượt quá 255 ký tự.',
            'image_upload.image' => 'Tệp tải lên phải là hình ảnh.',
            'image_upload.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png, gif hoặc webp.',
            'image_upload.max' => 'Ảnh không được vượt quá 5MB.',
            'link_url.required' => 'Vui lòng nhập liên kết.',
            'link_url.url' => 'Liên kết không hợp lệ.',
            'description.string' => 'Mô tả không hợp lệ.',
            'is_active.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image_upload')) {
            $validated['image'] = ImageUpload::store(
                $request->file('image_upload'),
                'banner_images',
            );
        }

        unset($validated['image_upload']);

        Ad::create($validated);
        ActivityLog::create([
            'module' => 'Ad',
            'action' => 'CREATE',
            'title' => $validated['name'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.ads.index')->with([
            'status' => 'success',
            'message' => 'Tạo quảng cáo thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        if (! Ad::where('id', $id)->exists()) {
            return view('admin.layouts.404', [
                'message' => 'Quảng cáo không tồn tại.'
            ]);
        }

        return view('admin.ads.form', [
            'ad' => Ad::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (! Ad::where('id', $id)->exists()) {
            return redirect()->route('admin.ads.index')->with([
                'status' => 'error',
                'message' => 'Quảng cáo không tồn tại.',
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'link_url' => ['required', 'url'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'updated_at' => ['required'],
        ], [
            'name.required' => 'Vui lòng nhập tên quảng cáo.',
            'name.string' => 'Tên quảng cáo không hợp lệ.',
            'name.max' => 'Tên quảng cáo không được vượt quá 255 ký tự.',
            'image_upload.image' => 'Tệp tải lên phải là hình ảnh.',
            'image_upload.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png, gif hoặc webp.',
            'image_upload.max' => 'Ảnh không được vượt quá 5MB.',
            'link_url.required' => 'Vui lòng nhập liên kết.',
            'link_url.url' => 'Liên kết không hợp lệ.',
            'description.string' => 'Mô tả không hợp lệ.',
            'is_active.boolean' => 'Trạng thái không hợp lệ.',
            'updated_at.required' => 'Dữ liệu cập nhật không hợp lệ.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $ad = Ad::findOrFail($id);

        if ($request->updated_at != $ad->updated_at->toDateTimeString()) {
            return redirect()->route('admin.ads.edit', $id)->with([
                'status' => 'error',
                'message' => 'Quảng cáo đã được cập nhật bởi người khác. Vui lòng tải lại trang và thử lại.',
            ]);
        }

        if ($request->hasFile('image_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('image_upload'),
                'banner_images',
                'public',
                $ad->image,
            );

            if ($imagePath !== null) {
                $validated['image'] = $imagePath;
            }
        }

        unset($validated['image_upload']);

        $ad->update($validated);
        ActivityLog::create([
            'module' => 'Ad',
            'action' => 'UPDATE',
            'title' => $validated['name'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.ads.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật quảng cáo thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        if (! Ad::where('id', $id)->exists()) {
            return redirect()->route('admin.ads.index')->with([
                'status' => 'error',
                'message' => 'Quảng cáo không tồn tại.',
            ]);
        }

        $ad = Ad::findOrFail($id);
        ImageUpload::delete($ad->image);
        $ad->delete();
        ActivityLog::create([
            'module' => 'Ad',
            'action' => 'DELETE',
            'title' => $ad->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.ads.index')->with([
            'status' => 'success',
            'message' => 'Xóa quảng cáo thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        if (! $request->filled('ids')) {
            return redirect()->route('admin.ads.index')->with([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất một quảng cáo để xóa.',
            ]);
        }

        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:ads,id'],
        ]);

        $adList = Ad::whereIn('id', $validated['ids'])->get();

        foreach ($adList as $ad) {
            ImageUpload::delete($ad->image);
            $ad->delete();

            ActivityLog::create([
                'module' => 'Ad',
                'action' => 'DELETE',
                'title' => $ad->name,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('admin.ads.index')->with([
            'status' => 'success',
            'message' => 'Xóa các quảng cáo đã chọn thành công.',
        ]);
    }
}
