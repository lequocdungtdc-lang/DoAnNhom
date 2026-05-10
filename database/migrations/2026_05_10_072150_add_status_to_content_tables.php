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
        Schema::table('artists', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('category_id');
        });

        Schema::table('songs', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('anh_daidien');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('id');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('id');
        });

        Schema::table('listening_history', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('id');
        });

        Schema::table('song_views', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('listening_history', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('song_views', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
