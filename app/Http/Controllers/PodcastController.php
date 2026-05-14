<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\ActivityLog;

class PodcastController extends Controller
{
    public function index(Request $request): View
    {
        // Lấy từ khóa tìm kiếm
        $search = $request->query('search');

        // Query mặc định
        $query = Podcast::latest();

        // Search
        if (!empty($search) && mb_strlen($search) > 2) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        return view('admin.podcasts.index', [
            'podcasts' => $query->paginate(10)->withQueryString(),
            // Tổng podcast đang hiển thị
            'totalPodcasts' => Podcast::where('status', true)->count(),
            // Tổng lượt nghe
            'totalViews' => Podcast::sum('views'),
            // Podcast nhiều view nhất
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
            'audio_file' => ['required', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        Podcast::create($validated);
        ActivityLog::create([
            'module' => 'Podcast',
            'action' => 'Tạo podcast',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);
        return redirect()
            ->route('admin.podcasts.index')
            ->with('status', 'Tạo podcast thành công.');
    }

    public function edit(int $id): View
    {
        return view('admin.podcasts.form', [
            'podcast' => Podcast::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'audio_file' => ['required', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        $podcast = Podcast::findOrFail($id);

        $podcast->update($validated);
        ActivityLog::create([
            'module' => 'Podcast',
            'action' => 'Cập nhật podcast',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);


        return redirect()
            ->route('admin.podcasts.index')
            ->with('status', 'Cập nhật podcast thành công.');
    }

    public function delete(int $id): RedirectResponse
    {
        $podcast = Podcast::findOrFail($id);

        $title = $podcast->title;

        $podcast->delete();

        ActivityLog::create([
            'module' => 'Podcast',
            'action' => 'Xóa podcast',
            'title' => $title,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.podcasts.index')
            ->with('status', 'Xóa podcast thành công.');
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
