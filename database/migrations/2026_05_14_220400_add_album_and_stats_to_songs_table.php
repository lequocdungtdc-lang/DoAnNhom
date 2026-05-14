<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            if (! Schema::hasColumn('songs', 'id_album')) {
                $table->unsignedBigInteger('id_album')->nullable()->after('theloai');
            }

            if (! Schema::hasColumn('songs', 'luot_nghe')) {
                $table->unsignedInteger('luot_nghe')->default(0)->after('anh_daidien');
            }

        });
    }

    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            foreach (['luot_nghe', 'id_album'] as $column) {
                if (Schema::hasColumn('songs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
