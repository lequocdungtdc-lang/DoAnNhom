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
            $table->boolean('status')->default(1)->after('thumbnail');
        });


        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'status')) {
                $table->enum('status', ['draft', 'published'])
                    ->default('published')
                    ->after('views');
            }
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

    

        Schema::table('listening_history', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('song_views', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};