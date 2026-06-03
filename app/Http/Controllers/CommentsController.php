<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Comment;
use App\Models\Song;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\News;
use App\Models\User;

class CommentsController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Comment::with([
            'user',
            'news',
        ])->latest();

        // Search
        if (!empty($search) && mb_strlen($search) > 2) {
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('fullname', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('news', function ($news) use ($search) {
                        $news->where('title', 'like', '%' . $search . '%');
                    });
            });
        }
        $randomComments = Comment::inRandomOrder()
            ->take(2)
            ->get();

        return view('admin.comments.index', [
            'comments' => $query->paginate(10)->withQueryString(),

            // Tổng comment
            'totalComments' => Comment::count(),

            // Comment đang active
            'activeComments' => Comment::where('status', true)->count(),

            // Comment mới nhất
            'latestComment' => Comment::latest()->first(),
            'randomComments' => $randomComments,
        ]);
    }

    public function create(): View
    {
        return view('admin.comments.form', [
            'comment' => new Comment(),
            'isEdit' => false,
            'news' => News::all(),
            'users' => User::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'new_id' => ['required', 'exists:news,id'],
            'content' => ['required', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        $comment = Comment::create($validated);

        ActivityLog::create([
            'module' => 'Comment',
            'action' => 'CREATE',
            'title' => $comment->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.comments.index')
            ->with([
                'status' => 'success',
                'message' => 'Tạo comment thành công.',
            ]);
    }

    public function edit(int $id): View
    {
        return view('admin.comments.form', [
            'comment' => Comment::findOrFail($id),
            'isEdit' => true,
            'news' => News::all(),
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'new_id' => ['required', 'exists:news,id'],
            'content' => ['required', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        $comment = Comment::findOrFail($id);

        $comment->update($validated);

        ActivityLog::create([
            'module' => 'Comment',
            'action' => 'UPDATE',
            'title' => $comment->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.comments.index')
            ->with([
                'status' => 'success',
                'message' => 'Cập nhật comment thành công.',
            ]);
    }

    public function delete(int $id): RedirectResponse
    {
        $comment = Comment::findOrFail($id);

        $title = $comment->content;

        $comment->delete();

        ActivityLog::create([
            'module' => 'Comment',
            'action' => 'DELETE',
            'title' => $title,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.comments.index')
            ->with([
                'status' => 'success',
                'message' => 'Xóa comment thành công.',
            ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:comments,id'],
        ]);

        $comments = Comment::whereIn('id', $validated['ids'])->get();

        foreach ($comments as $comment) {

            $title = $comment->content;

            $comment->delete();

            ActivityLog::create([
                'module' => 'Comment',
                'action' => 'DELETE',
                'title' => $title,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()
            ->route('admin.comments.index')
            ->with([
                'status' => 'success',
                'message' => 'Xóa các comment đã chọn thành công.',
            ]);
    }
}
