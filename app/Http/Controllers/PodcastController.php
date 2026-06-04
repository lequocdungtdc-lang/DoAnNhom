<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Support\AudioUpload;
use App\Support\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\ActivityLog;

class PodcastController extends Controller
{
    public function index(Request $request): View
    {
       
        $search = $request->query('search');

      
        $query = Podcast::latest();

        if (!empty($search) && mb_strlen($search) > 2) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        return view('admin.podcasts.index', [
            'podcasts' => $query->paginate(10)->withQueryString(),
           
            'totalPodcasts' => Podcast::where('status', true)->count(),
          
            'totalViews' => Podcast::sum('views'),
          
            'mostViewedPodcast' => Podcast::where('status', true)
                ->orderBy('views', 'desc')
                ->first(),

        ]);
    }

    public function create(): View
    {
        return view('admin.podcasts.form', [
            'podcast' => new Podcast(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'audio_upload' => ['required', 'file', 'mimes:mp3', 'max:512000'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'views' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['views'] = (int) ($validated['views'] ?? 0);
        $validated['audio_file'] = AudioUpload::store($request->file('audio_upload'), 'podcasts');

        if ($request->hasFile('image_upload')) {
            $validated['thumbnail'] = ImageUpload::store($request->file('image_upload'), 'podcast_images');
        }

        unset($validated['audio_upload'], $validated['image_upload']);

        Podcast::create($validated);
        ActivityLog::create([
            'module' => 'Podcast',
            'action' => 'CREATE',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);
        return redirect()
            ->route('admin.podcasts.index')
            ->with([
                'status' => 'success',
                'message' => 'Tạo podcast thành công.',
            ]);
    }

    public function edit(int $id): View
    {
        if (! Podcast::where('id', $id)->exists()) {
            return view('admin.layouts.404', [
                'message' => 'Podcast không tồn tại.'
            ]);
        }

        return view('admin.podcasts.form', [
            'podcast' => Podcast::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (! Podcast::where('id', $id)->exists()) {
            return redirect()->route('admin.podcasts.index')->with([
                'status' => 'error',
                'message' => 'Podcast không tồn tại.',
            ]);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'audio_upload' => ['nullable', 'file', 'mimes:mp3', 'max:512000'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'views' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'updated_at' => ['required'],
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['views'] = (int) ($validated['views'] ?? 0);

        $podcast = Podcast::findOrFail($id);

        if ($request->updated_at != $podcast->updated_at->toDateTimeString()) {
            return redirect()->route('admin.podcasts.edit', $id)->with([
                'status' => 'error',
                'message' => 'Podcast đã được cập nhật bởi người khác. Vui lòng tải lại trang và thử lại.',
            ]);
        }

        if ($request->hasFile('audio_upload')) {
            $validated['audio_file'] = AudioUpload::store(
                $request->file('audio_upload'),
                'podcasts',
                'public',
                $podcast->audio_file,
            );
        }

        if ($request->hasFile('image_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('image_upload'),
                'podcast_images',
                'public',
                $podcast->thumbnail,
            );

            if ($imagePath !== null) {
                $validated['thumbnail'] = $imagePath;
            }
        }

        unset($validated['audio_upload'], $validated['image_upload']);

        $podcast->update($validated);
        ActivityLog::create([
            'module' => 'Podcast',
            'action' => 'UPDATE',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);


        return redirect()
            ->route('admin.podcasts.index')
            ->with([
                'status' => 'success',
                'message' => 'Cập nhật podcast thành công.',
            ]);
    }

    public function delete(int $id): RedirectResponse
    {
        if (! Podcast::where('id', $id)->exists()) {
            return redirect()->route('admin.podcasts.index')->with([
                'status' => 'error',
                'message' => 'Podcast không tồn tại.',
            ]);
        }

        $podcast = Podcast::findOrFail($id);

        $title = $podcast->title;

        AudioUpload::delete($podcast->audio_file);
        ImageUpload::delete($podcast->thumbnail);

        $podcast->delete();

        ActivityLog::create([
            'module' => 'Podcast',
            'action' => 'DELETE',
            'title' => $title,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.podcasts.index')
            ->with([
                'status' => 'success',
                'message' => 'Xóa podcast thành công.',
            ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        if (! $request->filled('ids')) {
            return redirect()->route('admin.podcasts.index')->with([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất một podcast để xóa.',
            ]);
        }

        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:podcasts,id'],
        ]);

        $podcasts = Podcast::whereIn('id', $validated['ids'])->get();

        foreach ($podcasts as $podcast) {
            $title = $podcast->title;
            AudioUpload::delete($podcast->audio_file);
            ImageUpload::delete($podcast->thumbnail);
            $podcast->delete();

            ActivityLog::create([
                'module' => 'Podcast',
                'action' => 'DELETE',
                'title' => $title,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()
            ->route('admin.podcasts.index')
            ->with([
                'status' => 'success',
                'message' => 'Xóa các podcast đã chọn thành công.',
            ]);
    }

    public function show(int $id): View
    {
        $podcast = Podcast::findOrFail($id);

        // Tăng lượt nghe
        $podcast->increment('views');

        return view('podcasts.show', [
            'podcast' => $podcast,
        ]);
    }
}
