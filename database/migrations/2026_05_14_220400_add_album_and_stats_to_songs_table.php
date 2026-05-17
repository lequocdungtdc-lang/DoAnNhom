<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->foreign('artist_id')->references('id')->on('artists')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();

            if (! Schema::hasColumn('songs', 'album_id')) {
                $table->foreignId('album_id')->nullable()->after('category_id')->constrained('albums')->nullOnDelete();
            }

            if (! Schema::hasColumn('songs', 'listen_count')) {
                $table->unsignedInteger('listen_count')->default(0)->after('thumbnail');
            }

        });
    }

    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropForeign(['artist_id']);
            $table->dropForeign(['category_id']);

            if (Schema::hasColumn('songs', 'listen_count')) {
                $table->dropColumn('listen_count');
            }

            if (Schema::hasColumn('songs', 'album_id')) {
                $table->dropConstrainedForeignId('album_id');
            }
        });
    }
};
