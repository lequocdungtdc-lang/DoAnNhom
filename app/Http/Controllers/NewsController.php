<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = News::latest();
        if (! empty($search) && mb_strlen($search) > 2) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%');
        }
        return view('admin.news.index', [
            'newsList' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.form', [
            'news' => new News(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'summary' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        $slug = Str::slug($request->title);
        $count = News::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $validated['slug'] = $slug;
        $validated['user_id'] = auth()->id() ?? 1;
        $validated['views'] = 0;

        if ($request->hasFile('image_upload')) {
            $validated['image'] = ImageUpload::store($request->file('image_upload'), 'news_images');
        }

        unset($validated['image_upload']);

        News::create($validated);

        return redirect()->route('admin.news.index')->with([
            'status' => 'success',
            'message' => 'Thêm tin tức thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        return view('admin.news.form', [
            'news' => News::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'summary' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        $news = News::findOrFail($id);

        if ($request->hasFile('image_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('image_upload'),
                'news_images',
                'public',
                $news->image,
            );
            if ($imagePath !== null) {
                $validated['image'] = $imagePath;
            }
        }

        unset($validated['image_upload']);

        if ($request->title !== $news->title) {
            $slug = Str::slug($request->title);
            $count = News::where('slug', 'like', "{$slug}%")->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
            $validated['slug'] = $slug;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật tin tức thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        $news = News::findOrFail($id);
        ImageUpload::delete($news->image);
        $news->delete();

        return redirect()->route('admin.news.index')->with([
            'status' => 'success',
            'message' => 'Xóa tin tức thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:news,id'],
        ]);

        $newsList = News::whereIn('id', $validated['ids'])->get();

        foreach ($newsList as $news) {
            ImageUpload::delete($news->image);
            $news->delete();
        }

        return redirect()->route('admin.news.index')->with([
            'status' => 'success',
            'message' => 'Xóa các tin tức đã chọn thành công.',
        ]);
    }

    public function showPublic(Request $request): View
    {
        $news = News::where('status', 'published')
            ->latest()
            ->paginate(9);

        return view('web.news.index', compact('news'));
    }

    public function show(string $slug): View
    {
        $news = News::where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        $news->increment('views');

        $relatedNews = News::where('status', 'published')
            ->whereKeyNot($news->id)
            ->latest()
            ->take(3)
            ->get();

        return view('web.news.show', compact('news', 'relatedNews'));
    }
}
