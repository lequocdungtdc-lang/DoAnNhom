<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('listening_history', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('song_id')->after('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('listened_at')->after('song_id')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listening_history', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['song_id']);
            $table->dropColumn(['user_id', 'song_id', 'listened_at']);
        });
    }
};
