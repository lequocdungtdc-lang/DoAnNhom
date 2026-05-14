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
        Schema::create('_album', function (Blueprint $table) {
            $table->id();
             $table->string('ten_album');
            $table->string('nghe_si');
            $table->string('anh_bia')->nullable(); // đường dẫn ảnh bìa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_album');
    }
};
