<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\ActivityLog;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\Comment;

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
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề không hợp lệ.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung.',
            'content.string' => 'Nội dung không hợp lệ.',
            'summary.string' => 'Tóm tắt không hợp lệ.',
            'category.string' => 'Danh mục không hợp lệ.',
            'category.max' => 'Danh mục không được vượt quá 255 ký tự.',
            'image_upload.image' => 'Tệp tải lên phải là hình ảnh.',
            'image_upload.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png, gif hoặc webp.',
            'image_upload.max' => 'Ảnh không được vượt quá 4MB.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
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
        ActivityLog::create([
            'module' => 'News',
            'action' => 'CREATE',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.news.index')->with([
            'status' => 'success',
            'message' => 'Thêm tin tức thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        if (! News::where('id', $id)->exists()) {
            return view('admin.layouts.404', [
                'message' => 'Tin tức không tồn tại.'
            ]);
        }

        return view('admin.news.form', [
            'news' => News::findOrFail($id),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        if (! News::where('id', $id)->exists()) {
            return redirect()->route('admin.news.index')->with([
                'status' => 'error',
                'message' => 'Tin tức không tồn tại.',
            ]);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'summary' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'status' => ['required', 'in:draft,published,archived'],
            'updated_at' => ['required'],
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề không hợp lệ.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung.',
            'content.string' => 'Nội dung không hợp lệ.',
            'summary.string' => 'Tóm tắt không hợp lệ.',
            'category.string' => 'Danh mục không hợp lệ.',
            'category.max' => 'Danh mục không được vượt quá 255 ký tự.',
            'image_upload.image' => 'Tệp tải lên phải là hình ảnh.',
            'image_upload.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png, gif hoặc webp.',
            'image_upload.max' => 'Ảnh không được vượt quá 4MB.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'updated_at.required' => 'Dữ liệu cập nhật không hợp lệ.',
        ]);

        $news = News::findOrFail($id);

        if ($request->updated_at != $news->updated_at->toDateTimeString()) {
            return redirect()->route('admin.news.edit', $id)->with([
                'status' => 'error',
                'message' => 'Tin tức đã được cập nhật bởi người khác. Vui lòng tải lại trang và thử lại.',
            ]);
        }

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
        ActivityLog::create([
            'module' => 'News',
            'action' => 'UPDATE',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.news.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật tin tức thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        if (! News::where('id', $id)->exists()) {
            return redirect()->route('admin.news.index')->with([
                'status' => 'error',
                'message' => 'Tin tức không tồn tại.',
            ]);
        }

        $news = News::findOrFail($id);
        ImageUpload::delete($news->image);
        $news->delete();
        ActivityLog::create([
            'module' => 'News',
            'action' => 'DELETE',
            'title' => $news->title,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.news.index')->with([
            'status' => 'success',
            'message' => 'Xóa tin tức thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        if (! $request->filled('ids')) {
            return redirect()->route('admin.news.index')->with([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất một tin tức để xóa.',
            ]);
        }

        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:news,id'],
        ]);

        $newsList = News::whereIn('id', $validated['ids'])->get();

        foreach ($newsList as $news) {
            ImageUpload::delete($news->image);
            $news->delete();

            ActivityLog::create([
                'module' => 'News',
                'action' => 'DELETE',
                'title' => $news->title,
                'user_id' => auth()->id(),
            ]);
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
        $comments = Comment::with('user')
            ->where('new_id', $news->id) // hoặc news_id tùy DB của bạn
            ->latest()
            ->get();
        return view('web.news.show', compact(
            'news', 
            'relatedNews',
            'comments'
        ));
    }
}
