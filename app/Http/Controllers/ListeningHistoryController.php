<?php

namespace App\Http\Controllers;

use App\Models\ListeningHistory;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListeningHistoryController extends Controller
{
    public function store(Request $request, Song $song): JsonResponse
    {
        ListeningHistory::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'song_id' => $song->id,
            ],
            [
                'listened_at' => now(),
            ]
        );

        return response()->json(['ok' => true]);
    }
}
