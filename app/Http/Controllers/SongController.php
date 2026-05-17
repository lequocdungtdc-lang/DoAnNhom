<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Categories;
use App\Models\Song;
use App\Support\AudioUpload;
use App\Support\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\ActivityLog;
use App\Exports\SongsExport;
use App\Imports\SongsImport;
use Maatwebsite\Excel\Facades\Excel;

class SongController extends Controller
{


    public function index(Request $request): View
    {
        // Lấy từ khóa từ URL
        $search = $request->query('search');

        // Khởi tạo query với các quan hệ liên quan
        $query = Song::with(['artist', 'category', 'album'])->latest();

        // Nếu từ khóa > 2 ký tự (giống logic Categories bạn vừa đưa)
        if (! empty($search) && mb_strlen($search) > 2) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        return view('admin.songs.index', [
            'songs' => $query->paginate(10)->withQueryString(),
            'mostPopular' => Song::where('status', true)
                ->orderBy('listen_count', 'desc')
                ->first(),
        ]);
    }

    public function create(): View
    {
        return view('admin.songs.form', [
            'song' => new Song(),
            'albums' => Album::orderBy('title')->get(),
            'artists' => Artist::orderBy('name')->get(),
            'categories' => Categories::orderBy('name')->get(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist_id' => ['nullable', 'exists:artists,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'album_id' => ['nullable', 'exists:albums,id'],
            'audio_upload' => ['required', 'file', 'mimes:mp3', 'max:512000'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'listen_count' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['listen_count'] = (int) ($validated['listen_count'] ?? 0);
        $validated['audio_file'] = AudioUpload::store($request->file('audio_upload'), 'songs');

        if ($request->hasFile('image_upload')) {
            $validated['thumbnail'] = ImageUpload::store($request->file('image_upload'), 'song_images');
        }

        unset($validated['audio_upload'], $validated['image_upload']);

        Song::create($validated);
        ActivityLog::create([
            'module' => 'Song',
            'action' => 'CREATE',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.songs.index')
            ->with('status', 'Tạo bài hát thành công.');
    }

    public function edit(int $id): View
    {
        return view('admin.songs.form', [
            'song' => Song::findOrFail($id),
            'albums' => Album::orderBy('title')->get(),
            'artists' => Artist::orderBy('name')->get(),
            'categories' => Categories::orderBy('name')->get(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist_id' => ['nullable', 'exists:artists,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'album_id' => ['nullable', 'exists:albums,id'],
            'audio_upload' => ['nullable', 'file', 'mimes:mp3', 'max:512000'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'listen_count' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['listen_count'] = (int) ($validated['listen_count'] ?? 0);

        $song = Song::findOrFail($id);
        ActivityLog::create([
            'module' => 'Song',
            'action' => 'UPDATE',
            'title' => $validated['title'],
            'user_id' => auth()->id(),
        ]);

        if ($request->hasFile('audio_upload')) {
            $validated['audio_file'] = AudioUpload::store(
                $request->file('audio_upload'),
                'songs',
                'public',
                $song->audio_file,
            );
        }

        if ($request->hasFile('image_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('image_upload'),
                'song_images',
                'public',
                $song->thumbnail,
            );

            if ($imagePath !== null) {
                $validated['thumbnail'] = $imagePath;
            }
        }

        unset($validated['audio_upload'], $validated['image_upload']);

        $song->update($validated);

        return redirect()->route('admin.songs.index')
            ->with('status', 'Cập nhật bài hát thành công.');
    }

    public function delete(int $id): RedirectResponse
    {
        $song = Song::findOrFail($id);

        AudioUpload::delete($song->audio_file);
        ImageUpload::delete($song->thumbnail);

        $song->delete();
        ActivityLog::create([
            'module' => 'Song',
            'action' => 'DELETE',
            'title' => $song->title,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.songs.index')
            ->with('status', 'Xóa bài hát thành công.');
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:songs,id'],
        ]);

        $songs = Song::whereIn('id', $validated['ids'])->get();

        foreach ($songs as $song) {
            AudioUpload::delete($song->audio_file);
            ImageUpload::delete($song->thumbnail);
            $song->delete();

            ActivityLog::create([
                'module' => 'Song',
                'action' => 'DELETE',
                'title' => $song->title,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('admin.songs.index')
            ->with('status', 'Xóa các bài hát đã chọn thành công.');
    }

    //excel export
   public function export()
    {
        return Excel::download(
            new SongsExport,
            'danh-sach-bai-hat.xlsx'
        );
    }
    // excel import
    public function import(Request $request)
    {
        try {

            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);

            Excel::import(new SongsImport, $request->file('file'));

            return back()->with([
                'status' => 'success',
                'message' => 'Import Excel thành công',
            ]);

        } catch (\Exception $e) {

            return back()->with([
                'status' => 'error',
                'message' => 'Import thất bại: ' . $e->getMessage(),
            ]);
        }
    }
}
