<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;


// 🔹 USER ROUTES
Route::prefix('user')->group(function () {
    // 🔓 Public
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    // 🔐 Authenticated
    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/profile', 'profile');
            Route::post('/update-profile', 'updateProfile');
            Route::post('/logout', 'logout');
        });
        Route::controller(CategoriesController::class)->group(function () {
            Route::get('/categories', 'index');
            //Xóa danh mục
            Route::delete('/categories/{id}', 'delete');
        });
        Route::controller(SongController::class)->group(function () {
            Route::get('/song', 'index');
        });

        Route::controller(AlbumController::class)->group(function () {
            Route::get('/albums', 'index');
        });
    });
});

// 🔥 ADMIN ROUTES (tách riêng cho sạch)
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    // 👇 ví dụ quản lý user
    Route::get('/users', [UserController::class, 'index']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});
