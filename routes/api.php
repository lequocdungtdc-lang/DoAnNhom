<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/profile', 'profile');
            Route::post('/update-profile', 'updateProfile');
            Route::post('/logout', 'logout');
        });

        Route::controller(CategoriesController::class)->group(function () {
            Route::get('/categories', 'index');
            Route::delete('/categories/{id}', 'delete');
            Route::post('/categories/create', 'create');
            Route::get('/categories/{id}', 'edit');
            Route::put('/categories/{id}', 'update');
        });

        Route::controller(SongController::class)->group(function () {
            Route::get('/song', 'index');
        });

        Route::controller(AlbumController::class)->group(function () {
            Route::get('/albums', 'index');
        });
    });
});

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return response()->json([
                'message' => 'Admin dashboard',
            ]);
        });

        Route::get('/users', function () {
            return response()->json([
                'message' => 'User management route is not implemented in UserController yet.',
            ], 501);
        });
    });
