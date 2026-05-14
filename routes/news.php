<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;

// Frontend
Route::get('/tin-tuc', [NewsController::class, 'index'])->name('news.index');
Route::get('/tin-tuc/{slug}', [NewsController::class, 'show'])->name('news.show');

// Admin (sẽ thêm middleware auth sau)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('news', AdminNewsController::class)->names('admin.news');
});