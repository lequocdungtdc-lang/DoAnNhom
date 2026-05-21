<?php

namespace App\Http\Controllers;

use App\Models\Ad; // Khai báo chuẩn Model số ít
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function index()
    {
        //  Đã sửa: Đổi Ads thành Ad
        $ads = Ad::latest()->paginate(10);
        return view('admin.ad.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ad.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'media_type' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:5120',
            'link_url' => 'nullable|required|url',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('media_type')) {
            $validated['media_type'] = $request->file('media_type')->store('ads', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        //  Đã sửa: Đổi Ads thành Ad
        Ad::create($validated);

        return redirect()->route('admin.ads.index')->with('success', 'Quảng cáo đã được tạo thành công');
    }

    //  Đã sửa: Thay đổi Type-hint từ Ads sang Ad để nhận diện đúng Model Binding
    public function edit(Ad $ad)
    {
        return view('admin.ad.edit', compact('ad'));
    }

    //  Đã sửa: Thay đổi Type-hint từ Ads sang Ad
    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'media_type' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:5120',
            'link_url' => 'nullable|required|url',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('media_type')) {
            if ($ad->media_type && Storage::disk('public')->exists($ad->media_type)) {
                Storage::disk('public')->delete($ad->media_type);
            }

            $validated['media_type'] = $request->file('media_type')->store('ads', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $ad->update($validated);

        return redirect()->route('admin.ads.index');
    }

    //  Đã sửa: Thay đổi Type-hint từ Ads sang Ad
    public function destroy(Ad $ad)
    {
        if ($ad->media_type && Storage::disk('public')->exists($ad->media_type)) {
            Storage::disk('public')->delete($ad->media_type);
        }
        $ad->delete();
        return redirect()->route('admin.ads.index');
    }
}