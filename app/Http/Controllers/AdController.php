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
        return view('admin.ad.index', [
            'ads' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.ad.form', [
            'ad' => new Ad(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'media_type_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'link_url' => ['required', 'url'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('media_type_upload')) {
            $validated['media_type'] = ImageUpload::store(
                $request->file('media_type_upload'),
                'ad_images',
            );
        }

        unset($validated['media_type_upload']);

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

        return view('admin.ad.form', [
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
            'media_type_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'link_url' => ['required', 'url'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'updated_at' => ['required'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $ad = Ad::findOrFail($id);

        if ($request->updated_at != $ad->updated_at->toDateTimeString()) {
            return redirect()->route('admin.ads.edit', $id)->with([
                'status' => 'error',
                'message' => 'Quảng cáo đã được cập nhật bởi người khác. Vui lòng tải lại trang và thử lại.',
            ]);
        }

        if ($request->hasFile('media_type_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('media_type_upload'),
                'ad_images',
                'public',
                $ad->media_type,
            );

            if ($imagePath !== null) {
                $validated['media_type'] = $imagePath;
            }
        }

        unset($validated['media_type_upload']);

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
        ImageUpload::delete($ad->media_type);
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

        $ads = Ad::whereIn('id', $validated['ids'])->get();

        foreach ($ads as $ad) {
            ImageUpload::delete($ad->media_type);
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
