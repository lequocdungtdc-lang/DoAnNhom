<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\NewsController;

// === ADMIN NEWS ===
Route::prefix('admin')->group(function () {
    Route::get('/news', [App\Http\Controllers\Admin\NewsController::class, 'index'])->name('admin.news.index');
    Route::get('/news/create', [App\Http\Controllers\Admin\NewsController::class, 'create'])->name('admin.news.create');
    Route::post('/news', [App\Http\Controllers\Admin\NewsController::class, 'store'])->name('admin.news.store');
});
// Trang chủ - Dùng trang welcome mặc định của Laravel
Route::get('/', function () {
    return view('welcome');
});

// Tin tức
Route::get('/tin-tuc', [NewsController::class, 'index'])->name('news.index');
Route::get('/tin-tuc/{slug}', [NewsController::class, 'show'])->name('news.show');

// Giữ route cũ nếu cần
Route::get('/news', function () {
    return redirect('/tin-tuc');
});
// Trang xếp hạng (nếu có)
Route::get('/bang-xep-hang', [HomeController::class, 'rankings'])->name('rankings');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'web.dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/dashboard', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/', [UserController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
                Route::put('/{id}', [UserController::class, 'update'])->name('update');
                Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
            });

        Route::prefix('categories')
            ->name('categories.')
            ->group(function () {
                Route::get('/', [CategoriesController::class, 'index'])->name('index');
                Route::get('/create', [CategoriesController::class, 'create'])->name('create');
                Route::post('/', [CategoriesController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('edit');
                Route::put('/{id}', [CategoriesController::class, 'update'])->name('update');
                Route::delete('/{id}', [CategoriesController::class, 'delete'])->name('delete');
            });

        Route::prefix('songs')
            ->name('songs.')
            ->group(function () {
                Route::get('/', [SongController::class, 'index'])->name('index');
                Route::get('/create', [SongController::class, 'create'])->name('create');
                Route::post('/', [SongController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [SongController::class, 'edit'])->name('edit');
                Route::put('/{id}', [SongController::class, 'update'])->name('update');
                Route::delete('/{id}', [SongController::class, 'delete'])->name('delete');
            });

        Route::prefix('artists')
            ->name('artists.')
            ->group(function () {
                Route::get('/', [ArtistsController::class, 'index'])->name('index');
                Route::get('/create', [ArtistsController::class, 'create'])->name('create');
                Route::post('/', [ArtistsController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ArtistsController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ArtistsController::class, 'update'])->name('update');
                Route::delete('/{id}', [ArtistsController::class, 'delete'])->name('delete');
            });

        Route::prefix('albums')
            ->name('albums.')
            ->group(function () {
                Route::get('/', [AlbumController::class, 'index'])->name('index');
                Route::get('/create', [AlbumController::class, 'create'])->name('create');
                Route::post('/', [AlbumController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [AlbumController::class, 'edit'])->name('edit');
                Route::put('/{id}', [AlbumController::class, 'update'])->name('update');
                Route::delete('/{id}', [AlbumController::class, 'delete'])->name('delete');
            });
        Route::prefix('subscriptions')
            ->name('subscriptions.')
            ->group(function () {
                Route::get('/', [SubscriptionController::class, 'index'])->name('index');
                Route::get('/create', [SubscriptionController::class, 'create'])->name('create');

                Route::post('/', [SubscriptionController::class, 'store'])
                    ->name('store');

                Route::get('/{id}/edit', [SubscriptionController::class, 'edit'])
                    ->name('edit');

                Route::put('/{id}', [SubscriptionController::class, 'update'])
                    ->name('update');

                Route::delete('/{id}', [SubscriptionController::class, 'delete'])
                    ->name('delete');
            });
        Route::prefix('podcasts')
            ->name('podcasts.')
            ->group(function () {
                Route::get('/', [PodcastController::class, 'index'])->name('index');
                Route::get('/create', [PodcastController::class, 'create'])->name('create');
                Route::post('/', [PodcastController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [PodcastController::class, 'edit'])->name('edit');
                Route::put('/{id}', [PodcastController::class, 'update'])->name('update');
                Route::delete('/{id}', [PodcastController::class, 'delete'])->name('delete');
            });
        Route::get('/activity_logs', [ActivityLogController::class, 'index'])
            ->name('activities.index');
    });
