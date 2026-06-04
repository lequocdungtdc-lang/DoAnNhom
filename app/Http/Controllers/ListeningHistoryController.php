<?php

namespace App\Http\Controllers;

use App\Models\ListeningHistory;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListeningHistoryController extends Controller
{
    public function store(Request $request, Song $song): JsonResponse
    {
        if ($song->is_vip && !($request->user()->activeSubscription)) {
            return response()->json(['ok' => false, 'message' => 'Gói VIP cần thiết để nghe bài hát này.'], 403);
        }

        ListeningHistory::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'song_id' => $song->id,
                'listened_at' => now(),
            ],
            [
                'listened_seconds' => 0,
                'has_counted' => false,
            ]
        );

        return response()->json(['ok' => true]);
    }

    public function progress(Request $request, Song $song): JsonResponse
    {
        if ($song->is_vip && !($request->user()->activeSubscription)) {
            return response()->json(['ok' => false, 'message' => 'Gói VIP cần thiết để nghe bài hát này.'], 403);
        }

        $user = $request->user();
        $seconds = (int) $request->input('seconds', 0);

        if ($seconds <= 0) {
            return response()->json(['ok' => false, 'message' => 'Invalid seconds'], 400);
        }

        $history = ListeningHistory::where('user_id', $user->id)
            ->where('song_id', $song->id)
            ->whereDate('listened_at', now())
            ->first();

        if (!$history) {
            $history = ListeningHistory::create([
                'user_id' => $user->id,
                'song_id' => $song->id,
                'listened_at' => now(),
                'listened_seconds' => 0,
                'has_counted' => false,
            ]);
        }

        $history->listened_seconds += $seconds;
        $history->save();


        if ($history->listened_seconds >= 30 && !$history->has_counted) {
            DB::table('songs')->where('id', $song->id)->increment('listen_count');
            $history->has_counted = true;
            $history->save();
            
        }

        return response()->json([
            'ok' => true,
            'total_seconds' => $history->listened_seconds,
            'counted' => $history->has_counted,
        ]);
    }
}
