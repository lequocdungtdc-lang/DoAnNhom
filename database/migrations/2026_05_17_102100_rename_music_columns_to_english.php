<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'tentheloai') && ! Schema::hasColumn('categories', 'name')) {
                $table->renameColumn('tentheloai', 'name');
            }

            if (Schema::hasColumn('categories', 'nhom') && ! Schema::hasColumn('categories', 'group_name')) {
                $table->renameColumn('nhom', 'group_name');
            }
        });

        Schema::table('artists', function (Blueprint $table) {
            if (Schema::hasColumn('artists', 'name_artist') && ! Schema::hasColumn('artists', 'name')) {
                $table->renameColumn('name_artist', 'name');
            }

            if (Schema::hasColumn('artists', 'image_artist') && ! Schema::hasColumn('artists', 'image')) {
                $table->renameColumn('image_artist', 'image');
            }
        });

        Schema::table('albums', function (Blueprint $table) {
            if (Schema::hasColumn('albums', 'ten_album') && ! Schema::hasColumn('albums', 'title')) {
                $table->renameColumn('ten_album', 'title');
            }

            if (Schema::hasColumn('albums', 'nghe_si') && ! Schema::hasColumn('albums', 'artist_name')) {
                $table->renameColumn('nghe_si', 'artist_name');
            }

            if (Schema::hasColumn('albums', 'anh_bia') && ! Schema::hasColumn('albums', 'cover_image')) {
                $table->renameColumn('anh_bia', 'cover_image');
            }
        });

        Schema::table('songs', function (Blueprint $table) {
            if (Schema::hasColumn('songs', 'tenbaihat') && ! Schema::hasColumn('songs', 'title')) {
                $table->renameColumn('tenbaihat', 'title');
            }

            if (Schema::hasColumn('songs', 'nghesi') && ! Schema::hasColumn('songs', 'artist_id')) {
                $table->renameColumn('nghesi', 'artist_id');
            }

            if (Schema::hasColumn('songs', 'theloai') && ! Schema::hasColumn('songs', 'category_id')) {
                $table->renameColumn('theloai', 'category_id');
            }

            if (Schema::hasColumn('songs', 'id_album') && ! Schema::hasColumn('songs', 'album_id')) {
                $table->renameColumn('id_album', 'album_id');
            }

            if (Schema::hasColumn('songs', 'file_amthanh') && ! Schema::hasColumn('songs', 'audio_file')) {
                $table->renameColumn('file_amthanh', 'audio_file');
            }

            if (Schema::hasColumn('songs', 'anh_daidien') && ! Schema::hasColumn('songs', 'thumbnail')) {
                $table->renameColumn('anh_daidien', 'thumbnail');
            }

            if (Schema::hasColumn('songs', 'luot_nghe') && ! Schema::hasColumn('songs', 'listen_count')) {
                $table->renameColumn('luot_nghe', 'listen_count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            if (Schema::hasColumn('songs', 'title') && ! Schema::hasColumn('songs', 'tenbaihat')) {
                $table->renameColumn('title', 'tenbaihat');
            }

            if (Schema::hasColumn('songs', 'artist_id') && ! Schema::hasColumn('songs', 'nghesi')) {
                $table->renameColumn('artist_id', 'nghesi');
            }

            if (Schema::hasColumn('songs', 'category_id') && ! Schema::hasColumn('songs', 'theloai')) {
                $table->renameColumn('category_id', 'theloai');
            }

            if (Schema::hasColumn('songs', 'album_id') && ! Schema::hasColumn('songs', 'id_album')) {
                $table->renameColumn('album_id', 'id_album');
            }

            if (Schema::hasColumn('songs', 'audio_file') && ! Schema::hasColumn('songs', 'file_amthanh')) {
                $table->renameColumn('audio_file', 'file_amthanh');
            }

            if (Schema::hasColumn('songs', 'thumbnail') && ! Schema::hasColumn('songs', 'anh_daidien')) {
                $table->renameColumn('thumbnail', 'anh_daidien');
            }

            if (Schema::hasColumn('songs', 'listen_count') && ! Schema::hasColumn('songs', 'luot_nghe')) {
                $table->renameColumn('listen_count', 'luot_nghe');
            }
        });

        Schema::table('albums', function (Blueprint $table) {
            if (Schema::hasColumn('albums', 'title') && ! Schema::hasColumn('albums', 'ten_album')) {
                $table->renameColumn('title', 'ten_album');
            }

            if (Schema::hasColumn('albums', 'artist_name') && ! Schema::hasColumn('albums', 'nghe_si')) {
                $table->renameColumn('artist_name', 'nghe_si');
            }

            if (Schema::hasColumn('albums', 'cover_image') && ! Schema::hasColumn('albums', 'anh_bia')) {
                $table->renameColumn('cover_image', 'anh_bia');
            }
        });

        Schema::table('artists', function (Blueprint $table) {
            if (Schema::hasColumn('artists', 'name') && ! Schema::hasColumn('artists', 'name_artist')) {
                $table->renameColumn('name', 'name_artist');
            }

            if (Schema::hasColumn('artists', 'image') && ! Schema::hasColumn('artists', 'image_artist')) {
                $table->renameColumn('image', 'image_artist');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'name') && ! Schema::hasColumn('categories', 'tentheloai')) {
                $table->renameColumn('name', 'tentheloai');
            }

            if (Schema::hasColumn('categories', 'group_name') && ! Schema::hasColumn('categories', 'nhom')) {
                $table->renameColumn('group_name', 'nhom');
            }
        });
    }
};
