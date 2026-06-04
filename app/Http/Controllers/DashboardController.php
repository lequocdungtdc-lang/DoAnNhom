<?php

namespace App\Http\Controllers;

use App\Models\ListeningHistory;
use App\Support\AudioUpload;
use App\Support\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $recentHistory = $request->user()
            ->listeningHistory()
            ->with(['song.artist', 'song.category'])
            ->latest('listened_at')
            ->limit(5)
            ->get()
            ->map(function (ListeningHistory $history) {
                $song = $history->song;
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist' => $song->artist?->name ?? 'Nghệ sĩ chưa cập nhật',
                    'category' => $song->category?->name ?? 'Chưa phân loại',
                    'thumbnail' => ImageUpload::url($song->thumbnail),
                    'audio_url' => AudioUpload::url($song->audio_file),
                    'listened_at' => $history->listened_at,
                ];
            });

        return view('web.dashboard', [
            'recentHistory' => $recentHistory,
        ]);
    }
}
