<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FavoriteSongController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListeningHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Web\PlanController as WebPlanController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\NewsController;

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\AdController;


// Tin tức (Web - User)
Route::get('/tin-tuc', [NewsController::class, 'showPublic'])->name('news.index');
Route::get('/tin-tuc/{slug}', [NewsController::class, 'show'])->name('news.show');

// Trang chủ - Dùng trang welcome mặc định của Laravel
Route::get('/', function () {
    return view('welcome');
});



// Trang xếp hạng (nếu có)
Route::get('/bang-xep-hang', [HomeController::class, 'rankings'])->name('rankings');
Route::get('/artists', [HomeController::class, 'artistsIndex'])->name('artists.index');
Route::get('/nghe-si/{artist}', [HomeController::class, 'artistShow'])->name('artists.show');
Route::get('/podcasts', [HomeController::class, 'podcastsIndex'])->name('podcasts.index');
Route::get('/podcasts/{podcast}', [HomeController::class, 'podcastShow'])->name('podcasts.show');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/listening-history/{song}', [ListeningHistoryController::class, 'store'])->name('listening-history.store');
    Route::post('/listening-history/{song}/progress', [ListeningHistoryController::class, 'progress'])->name('listening-history.progress');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/favorites', [FavoriteSongController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{song}', [FavoriteSongController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::post('/playlists/songs/{song}', [PlaylistController::class, 'addSong'])->name('playlists.songs.add');
    Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong'])->name('playlists.songs.remove');
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'delete'])->name('playlists.delete');
    Route::get('/goi-dang-ky', [WebPlanController::class, 'index'])->name('plans.index');
    Route::get('/goi-dang-ky/{plan}/thanh-toan', [WebPlanController::class, 'showPayment'])->name('plans.payment');
    Route::get('/goi-dang-ky/vnpay-return', [WebPlanController::class, 'vnpayReturn'])->name('plans.vnpay.return');
    Route::post('/goi-dang-ky/{plan}', [WebPlanController::class, 'subscribe'])->name('plans.subscribe');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/news/comment', [CommentsController::class, 'storeWeb'])->name('web.comments.store');
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
                Route::delete('/bulk-delete', [UserController::class, 'bulkDelete'])->name('bulk-delete');
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
                Route::delete('/bulk-delete', [CategoriesController::class, 'bulkDelete'])->name('bulk-delete');
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
                Route::delete('/bulk-delete', [SongController::class, 'bulkDelete'])->name('bulk-delete');
                Route::delete('/{id}', [SongController::class, 'delete'])->name('delete');
                Route::get('/export', [SongController::class, 'export'])->name('export');
                Route::post('/import', [SongController::class, 'import'])->name('import');
            });

        Route::prefix('artists')
            ->name('artists.')
            ->group(function () {
                Route::get('/', [ArtistsController::class, 'index'])->name('index');
                Route::get('/create', [ArtistsController::class, 'create'])->name('create');
                Route::post('/', [ArtistsController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [ArtistsController::class, 'edit'])->name('edit');
                Route::put('/{id}', [ArtistsController::class, 'update'])->name('update');
                Route::delete('/bulk-delete', [ArtistsController::class, 'bulkDelete'])->name('bulk-delete');
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
                Route::delete('/bulk-delete', [AlbumController::class, 'bulkDelete'])->name('bulk-delete');
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

                Route::delete('/bulk-delete', [SubscriptionController::class, 'bulkDelete'])
                    ->name('bulk-delete');

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
                Route::delete('/bulk-delete', [PodcastController::class, 'bulkDelete'])->name('bulk-delete');
                Route::delete('/{id}', [PodcastController::class, 'delete'])->name('delete');
            });
        Route::get('/activity_logs', [ActivityLogController::class, 'index'])
            ->name('activities.index');

        Route::get('/podcast/{id}', [PodcastController::class, 'show'])
            ->name('podcasts.show');
        Route::prefix('comments')
            ->name('comments.')
            ->group(function () {
                Route::get('/', [CommentsController::class, 'index'])->name('index');
                Route::get('/create', [CommentsController::class, 'create'])->name('create');
                Route::post('/', [CommentsController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [CommentsController::class, 'edit'])->name('edit');
                Route::put('/{id}', [CommentsController::class, 'update'])->name('update');
                Route::delete('/bulk-delete', [CommentsController::class, 'bulkDelete'])->name('bulk-delete');
                Route::delete('/{id}', [CommentsController::class, 'delete'])->name('delete');
            });




        Route::prefix('news')
            ->name('news.')
            ->group(function () {
                Route::get('/', [NewsController::class, 'index'])->name('index');
                Route::get('/create', [NewsController::class, 'create'])->name('create');
                Route::post('/', [NewsController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [NewsController::class, 'edit'])->name('edit');
                Route::put('/{id}', [NewsController::class, 'update'])->name('update');
                Route::delete('/bulk-delete', [NewsController::class, 'bulkDelete'])->name('bulk-delete');
                Route::delete('/{id}', [NewsController::class, 'delete'])->name('delete');
            });

        Route::prefix('ads')
            ->name('ads.')
            ->group(function () {
                Route::get('/', [AdController::class, 'index'])->name('index');
                Route::get('/create', [AdController::class, 'create'])->name('create');
                Route::post('/', [AdController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [AdController::class, 'edit'])->name('edit');
                Route::put('/{id}', [AdController::class, 'update'])->name('update');
                Route::delete('/bulk-delete', [AdController::class, 'bulkDelete'])->name('bulk-delete');
                Route::delete('/{id}', [AdController::class, 'delete'])->name('delete');
            });
    });
