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
                $q->where('tenbaihat', 'like', '%' . $search . '%');
            });
        }

        return view('admin.songs.index', [
            'songs' => $query->paginate(10)->withQueryString(),
            'mostPopular' => Song::where('status', true)
                ->orderBy('luot_nghe', 'desc')
                ->first(),
        ]);
    }

    public function create(): View
    {
        return view('admin.songs.form', [
            'song' => new Song(),
            'albums' => Album::orderBy('ten_album')->get(),
            'artists' => Artist::orderBy('name_artist')->get(),
            'categories' => Categories::orderBy('tentheloai')->get(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tenbaihat' => ['required', 'string', 'max:255'],
            'nghesi' => ['nullable', 'exists:artists,id'],
            'theloai' => ['required', 'exists:categories,id'],
            'id_album' => ['nullable', 'exists:albums,id'],
            'audio_upload' => ['required', 'file', 'mimes:mp3', 'max:512000'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'luot_nghe' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['luot_nghe'] = (int) ($validated['luot_nghe'] ?? 0);
        $validated['file_amthanh'] = AudioUpload::store($request->file('audio_upload'), 'songs');

        if ($request->hasFile('image_upload')) {
            $validated['anh_daidien'] = ImageUpload::store($request->file('image_upload'), 'song_images');
        }

        unset($validated['audio_upload'], $validated['image_upload']);

        Song::create($validated);
        ActivityLog::create([
            'module' => 'Song',
            'action' => 'CREATE',
            'title' => $validated['tenbaihat'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.songs.index')
            ->with('status', 'Tạo bài hát thành công.');
    }

    public function edit(int $id): View
    {
        return view('admin.songs.form', [
            'song' => Song::findOrFail($id),
            'albums' => Album::orderBy('ten_album')->get(),
            'artists' => Artist::orderBy('name_artist')->get(),
            'categories' => Categories::orderBy('tentheloai')->get(),
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'tenbaihat' => ['required', 'string', 'max:255'],
            'nghesi' => ['nullable', 'exists:artists,id'],
            'theloai' => ['required', 'exists:categories,id'],
            'id_album' => ['nullable', 'exists:albums,id'],
            'audio_upload' => ['nullable', 'file', 'mimes:mp3', 'max:512000'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'luot_nghe' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['luot_nghe'] = (int) ($validated['luot_nghe'] ?? 0);

        $song = Song::findOrFail($id);
        ActivityLog::create([
            'module' => 'Song',
            'action' => 'UPDATE',
            'title' => $validated['tenbaihat'],
            'user_id' => auth()->id(),
        ]);

        if ($request->hasFile('audio_upload')) {
            $validated['file_amthanh'] = AudioUpload::store(
                $request->file('audio_upload'),
                'songs',
                'public',
                $song->file_amthanh,
            );
        }

        if ($request->hasFile('image_upload')) {
            $imagePath = ImageUpload::store(
                $request->file('image_upload'),
                'song_images',
                'public',
                $song->anh_daidien,
            );

            if ($imagePath !== null) {
                $validated['anh_daidien'] = $imagePath;
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

        AudioUpload::delete($song->file_amthanh);
        ImageUpload::delete($song->anh_daidien);

        $song->delete();
        ActivityLog::create([
            'module' => 'Song',
            'action' => 'DELETE',
            'title' => $song->tenbaihat,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.songs.index')
            ->with('status', 'Xóa bài hát thành công.');
    }
}
