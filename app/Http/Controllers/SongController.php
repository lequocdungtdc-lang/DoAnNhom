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
use Illuminate\Support\Facades\DB;

class SongController extends Controller
{


    public function index(Request $request): View
    {
        $search = $request->query('search');
        $selectedYear = (int) $request->query('year', now()->year);

        $query = Song::with(['artist', 'category', 'album'])->latest();

        if (! empty($search) && mb_strlen($search) > 2) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }
        $randomSongs = Song::inRandomOrder()
            ->take(2)
            ->get();

        $monthlyListens = DB::table('listening_history')
            ->whereYear('listened_at', $selectedYear)
            ->where('has_counted', true)
            ->select(
                DB::raw('MONTH(listened_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(listened_at)'))
            ->orderBy('month')
            ->get();

        $availableYears = DB::table('listening_history')
            ->where('has_counted', true)
            ->selectRaw('YEAR(listened_at) as year')
            ->groupBy(DB::raw('YEAR(listened_at)'))
            ->orderByDesc('year')
            ->pluck('year');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([now()->year]);
        }

        return view('admin.songs.index', [
            'songs' => $query->paginate(10)->withQueryString(),
            'mostPopular' => Song::where('status', true)
                ->orderBy('listen_count', 'desc')
                ->first(),
            'monthlyListens' => $monthlyListens,
            'chartLabels' => $monthlyListens->pluck('month'),
            'chartData' => $monthlyListens->pluck('total'),
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
            'randomSongs' => $randomSongs,
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
       $validated = $request->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'artist_id' => ['nullable', 'exists:artists,id'],
                'category_id' => ['required', 'exists:categories,id'],
                'album_id' => ['nullable', 'exists:albums,id'],
                'audio_upload' => ['required', 'file', 'mimes:mp3', 'max:512000'],
                'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
                'listen_count' => ['nullable', 'integer', 'min:0'],
                'status' => ['nullable', 'boolean'],
                'is_vip' => ['nullable', 'boolean'],
            ],
            [
                // title
                'title.required' => 'Vui lòng nhập tên bài hát.',
                'title.string' => 'Tên bài hát không hợp lệ.',
                'title.max' => 'Tên bài hát không được vượt quá 255 ký tự.',

                // artist
                'artist_id.exists' => 'Nghệ sĩ được chọn không tồn tại.',

                // category
                'category_id.required' => 'Vui lòng chọn thể loại.',
                'category_id.exists' => 'Thể loại được chọn không tồn tại.',

                // album
                'album_id.exists' => 'Album được chọn không tồn tại.',

                // audio
                'audio_upload.required' => 'Vui lòng tải lên file nhạc.',
                'audio_upload.file' => 'File nhạc không hợp lệ.',
                'audio_upload.mimes' => 'File nhạc phải có định dạng MP3.',
                'audio_upload.max' => 'File nhạc không được vượt quá 500MB.',

                // image
                'image_upload.image' => 'Tệp tải lên phải là hình ảnh.',
                'image_upload.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png, gif hoặc webp.',
                'image_upload.max' => 'Ảnh không được vượt quá 4MB.',

                // listen count
                'listen_count.integer' => 'Lượt nghe phải là số nguyên.',
                'listen_count.min' => 'Lượt nghe không được nhỏ hơn 0.',

                // boolean
                'status.boolean' => 'Trạng thái không hợp lệ.',
                'is_vip.boolean' => 'Giá trị VIP không hợp lệ.',
            ]
        );

        $validated['status'] = $request->boolean('status');
        $validated['is_vip'] = $request->boolean('is_vip');
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

        return redirect()->route('admin.songs.index')->with([
            'status' => 'success',
            'message' => 'Tạo bài hát thành công.',
        ]);
    }

    public function edit(int $id): View
    {
        if (!Song::where('id', $id)->exists()) {
            return view('admin.layouts.404', [
                'message' => 'Bài hát không tồn tại.'
            ]);
        }
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
        if (!Song::where('id', $id)->exists()) {
            return redirect()->route('admin.songs.index')->with([
                'status' => 'error',
                'message' => 'Bài hát không tồn tại.',
            ]);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'artist_id' => ['nullable', 'exists:artists,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'album_id' => ['nullable', 'exists:albums,id'],
            'audio_upload' => ['nullable', 'file', 'mimes:mp3', 'max:512000'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'listen_count' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'is_vip' => ['nullable', 'boolean'],
            'updated_at' => ['required'],
        ],
            [
            // title
            'title.required' => 'Vui lòng nhập tên bài hát.',
            'title.string' => 'Tên bài hát không hợp lệ.',
            'title.max' => 'Tên bài hát không được vượt quá 255 ký tự.',

            // artist
            'artist_id.exists' => 'Nghệ sĩ được chọn không tồn tại.',

            // category
            'category_id.required' => 'Vui lòng chọn thể loại.',
            'category_id.exists' => 'Thể loại được chọn không tồn tại.',

            // album
            'album_id.exists' => 'Album được chọn không tồn tại.',

            // audio
            'audio_upload.file' => 'File nhạc không hợp lệ.',
            'audio_upload.mimes' => 'File nhạc phải có định dạng MP3.',
            'audio_upload.max' => 'File nhạc không được vượt quá 500MB.',

            // image
            'image_upload.image' => 'Tệp tải lên phải là hình ảnh.',
            'image_upload.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png, gif hoặc webp.',
            'image_upload.max' => 'Ảnh không được vượt quá 4MB.',

            // listen count
            'listen_count.integer' => 'Lượt nghe phải là số nguyên.',
            'listen_count.min' => 'Lượt nghe không được nhỏ hơn 0.',

            // boolean
            'status.boolean' => 'Trạng thái không hợp lệ.',
            'is_vip.boolean' => 'Giá trị VIP không hợp lệ.',
            // updated_at
            'updated_at.required' => 'Dữ liệu cập nhật không hợp lệ.',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['is_vip'] = $request->boolean('is_vip');
        $validated['listen_count'] = (int) ($validated['listen_count'] ?? 0);

        $song = Song::findOrFail($id);
        // CHECK CONFLICT
        if ($request->updated_at != $song->updated_at->toDateTimeString()) {
            return redirect()->route('admin.songs.edit', $id)->with([
                'status' => 'error',
                'message' => 'Bài hát đã được cập nhật bởi người khác. Vui lòng tải lại trang và thử lại.',
            ]);
        }
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

        if (!Song::where('id', $id)->exists()) {
            return view('admin.layouts.404', [
                'message' => 'Bài hát không tồn tại.'
            ]);
        }
        
        $song->update($validated);

        return redirect()->route('admin.songs.index')->with([
            'status' => 'success',
            'message' => 'Cập nhật bài hát thành công.',
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        if (!Song::where('id', $id)->exists()) {
            return redirect()->route('admin.songs.index')->with([
                'status' => 'error',
                'message' => 'Bài hát không tồn tại.',
            ]);
        }
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

        return redirect()->route('admin.songs.index')->with([
            'status' => 'success',
            'message' => 'Xóa bài hát thành công.',
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        if (! $request->filled('ids')) {
            return redirect()->route('admin.songs.index')->with([
                'status' => 'error',
                'message' => 'Vui lòng chọn ít nhất một bài hát để xóa.',
            ]);
        }

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

        return redirect()->route('admin.songs.index')->with([
            'status' => 'success',
            'message' => 'Xóa các bài hát đã chọn thành công.',
        ]);
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
                'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
            ], [
                'file.required' => 'Vui lòng chọn file Excel để import.',
                'file.file' => 'File import không hợp lệ.',
                'file.mimes' => 'File import phải có định dạng xlsx, xls hoặc csv.',
                'file.max' => 'File import không được vượt quá 10MB.',
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
