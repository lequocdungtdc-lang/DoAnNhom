<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('song_user_likes', 'user_id') || ! Schema::hasColumn('song_user_likes', 'song_id')) {
            DB::table('song_user_likes')->delete();
        }

        Schema::table('song_user_likes', function (Blueprint $table) {
            if (! Schema::hasColumn('song_user_likes', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            }

            if (! Schema::hasColumn('song_user_likes', 'song_id')) {
                $table->foreignId('song_id')->after('user_id')->constrained()->cascadeOnDelete();
            }
        });

        DB::table('song_user_likes')
            ->where('user_id', '<=', 0)
            ->orWhere('song_id', '<=', 0)
            ->delete();

        DB::table('song_user_likes')
            ->selectRaw('MIN(id) as keep_id, user_id, song_id, COUNT(*) as total')
            ->groupBy('user_id', 'song_id')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->each(function ($duplicate) {
                DB::table('song_user_likes')
                    ->where('user_id', $duplicate->user_id)
                    ->where('song_id', $duplicate->song_id)
                    ->where('id', '!=', $duplicate->keep_id)
                    ->delete();
            });

        Schema::table('song_user_likes', function (Blueprint $table) {
            $table->unique(['user_id', 'song_id']);
        });
    }

    public function down(): void
    {
        Schema::table('song_user_likes', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'song_id']);

            if (Schema::hasColumn('song_user_likes', 'song_id')) {
                $table->dropConstrainedForeignId('song_id');
            }

            if (Schema::hasColumn('song_user_likes', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
