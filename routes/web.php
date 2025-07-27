<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SSOController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SongRequestController as AdminSongRequestController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\SongRequestController;
use App\Http\Controllers\Api\SongRequestController as ApiSongRequestController;
use App\Http\Controllers\Top40Controller;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\VacatureController;
use App\Http\Controllers\Admin\VacancyController as AdminVacancyController;

// Public routes
Route::get('/', function () {
    // Get upcoming shows
    $upcomingShows = app(ProgramController::class)->getUpcomingShows(3);
    // Get recent news
    $recentNews = app(PublicNewsController::class)->getRecentNews(4);
    // Get TOP40 data
    $top40Data = app(Top40Controller::class)->getTop5AndNewEntries();
    return view('welcome', compact('upcomingShows', 'recentNews', 'top40Data'));
	
});
Route::get('/nl/over-ons', function () {
    return view('pages.about');
});
Route::get('/nl/contact', function () {
    return view('pages.contact');
});
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');
Route::get('/nl/programmering', [ProgramController::class, 'index'])->name('program');
Route::get('/nl/nieuws', [PublicNewsController::class, 'index'])->name('news');
Route::get('/nl/nieuws/categorie/{slug}', [PublicNewsController::class, 'category'])->name('news.category');
Route::get('/nl/nieuws/tag/{slug}', [PublicNewsController::class, 'tag'])->name('news.tag');
Route::get('/nl/nieuws/{slug}', [PublicNewsController::class, 'show'])->name('news.show');
Route::post('/nl/nieuws/{slug}/comments', [NewsCommentController::class, 'store'])->name('news.comments.store');
Route::get('/nl/top40', [Top40Controller::class, 'index'])->name('top40');
Route::get('/vacatures', [VacancyController::class, 'index'])->name('vacatures.index');
Route::get('/vacatures/{vacancy}', [VacancyController::class, 'show'])->name('vacatures.show');
Route::post('/vacatures/{vacancy}/solliciteer', [VacatureController::class, 'store'])->name('vacatures.apply');




// Authentication routes
Route::get('/inloggen', function () {
    return view('auth.login');
})->name('login');

Route::get('/sso/redirect', [SSOController::class, 'redirectToSso'])->name('sso.redirect');
Route::get('/sso/callback', [SSOController::class, 'handleCallback'])->name('sso.callback');
Route::post('/logout', [SSOController::class, 'logout'])->name('logout');

// Local development authentication routes
Route::get('/local-login', [SSOController::class, 'showLocalLoginForm'])->name('local.login.form');
Route::post('/local-login', [SSOController::class, 'localLogin'])->name('local.login');

// API route voor verzoeknummers
Route::match(['get', 'post'], '/api/verzoeknummer/indienen', [ApiSongRequestController::class, 'store'])->name('api.song-request.store');

// Admin routes (protected)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'staff'])->group(function () {
    // Routes accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== DJ Role Routes =====
    // DJ Schedule routes that are read-only or only affect the user's own data
    Route::middleware(['permission:any,view-dj-schedule,manage-own-availability'])->group(function() {
        Route::get('/schedule', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedule.index');
        Route::get('/schedule/availability', [\App\Http\Controllers\Admin\ScheduleController::class, 'availability'])->name('schedule.availability');
        Route::post('/schedule/availability/store', [\App\Http\Controllers\Admin\ScheduleController::class, 'storeAvailability'])->name('schedule.availability.store');
        // Song request routes
        Route::get('/song-requests', [AdminSongRequestController::class, 'index'])->name('song-requests.index');
        Route::patch('/song-requests/{id}/status', [AdminSongRequestController::class, 'updateStatus'])->middleware('permission:any,process-requests')->name('song-requests.update-status');
        Route::delete('/song-requests/{id}', [AdminSongRequestController::class, 'destroy'])->middleware('permission:any,delete-requests')->name('song-requests.destroy');
        Route::get('/song-requests/recent', [App\Http\Controllers\Admin\DashboardController::class, 'getRecentSongRequests'])->name('song-requests.recent');

    });


    // ===== Editorial Role Routes =====
    // Editorial content management routes
    Route::middleware(['permission:any,view-news,create-news,edit-news,view-categories,view-tags,view-comments'])->group(function() {
        // News routes
        Route::get('/news', [NewsController::class, 'index'])->name('news.index');
        Route::get('/news/create', [NewsController::class, 'create'])->middleware('permission:any,create-news')->name('news.create');
        Route::post('/news', [NewsController::class, 'store'])->middleware('permission:any,create-news')->name('news.store');
        Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->middleware('permission:any,edit-news')->name('news.edit');
        Route::put('/news/{news}', [NewsController::class, 'update'])->middleware('permission:any,edit-news')->name('news.update');
        Route::delete('/news/{news}', [NewsController::class, 'destroy'])->middleware('permission:any,delete-news')->name('news.destroy');

        // Category routes
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        // Tag routes
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);

        // Comment routes
        Route::get('/comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
        Route::get('/comments/pending', [\App\Http\Controllers\Admin\CommentController::class, 'pending'])->middleware('permission:any,moderate-comments')->name('comments.pending');
        Route::patch('/comments/{comment}/approve', [\App\Http\Controllers\Admin\CommentController::class, 'approve'])->middleware('permission:any,moderate-comments')->name('comments.approve');
        Route::delete('/comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->middleware('permission:any,delete-comments')->name('comments.destroy');

        // TOP40 routes
        Route::get('/top40', [\App\Http\Controllers\Admin\Top40Controller::class, 'index'])->name('top40.index');
        Route::get('/top40/create', [\App\Http\Controllers\Admin\Top40Controller::class, 'create'])->name('top40.create');
        Route::post('/top40', [\App\Http\Controllers\Admin\Top40Controller::class, 'store'])->name('top40.store');
        Route::get('/top40/{top40}/edit', [\App\Http\Controllers\Admin\Top40Controller::class, 'edit'])->name('top40.edit');
        Route::put('/top40/{top40}', [\App\Http\Controllers\Admin\Top40Controller::class, 'update'])->name('top40.update');
        Route::delete('/top40/{top40}', [\App\Http\Controllers\Admin\Top40Controller::class, 'destroy'])->name('top40.destroy');
        Route::post('/top40/reorder', [\App\Http\Controllers\Admin\Top40Controller::class, 'reorder'])->name('top40.reorder');
    });

    // ===== Admin-only routes =====
    Route::middleware(['permission:any,view-programs,create-programs,edit-programs,delete-programs,view-users,edit-users,view-requests,process-requests,delete-requests,manage-all-availability,assign-djs'])->group(function() {
        // Program routes
        Route::resource('programs', AdminProgramController::class);
    Route::get('/vacatures', [AdminVacancyController::class, 'index'])->name('vacancies.index');
    Route::get('/vacatures/aanmaken', [AdminVacancyController::class, 'create'])->name('vacancies.create');
    Route::post('/vacatures', [AdminVacancyController::class, 'store'])->name('vacancies.store');
    Route::get('/vacatures/{vacancy}/bewerken', [AdminVacancyController::class, 'edit'])->name('vacancies.edit');
    Route::put('/vacatures/{vacancy}', [AdminVacancyController::class, 'update'])->name('vacancies.update');
    Route::delete('/vacatures/{vacancy}', [AdminVacancyController::class, 'destroy'])->name('vacancies.destroy');
	Route::get('/sollicitaties', [\App\Http\Controllers\Admin\ApplyController::class, 'index'])->name('sollicitaties.index');
    Route::get('/sollicitaties/{vacature}', [\App\Http\Controllers\Admin\ApplyController::class, 'show'])->name('sollicitaties.show');
	Route::delete('/sollicitaties/{vacature}', [\App\Http\Controllers\Admin\ApplyController::class, 'destroy'])->name('sollicitaties.destroy');



        // User management routes
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

        // Admin-only DJ scheduling routes
        Route::get('/schedule/assignments', [\App\Http\Controllers\Admin\ScheduleController::class, 'assignments'])->middleware('permission:any,assign-djs')->name('schedule.assignments');
        Route::post('/schedule/assignments/store', [\App\Http\Controllers\Admin\ScheduleController::class, 'storeAssignments'])->middleware('permission:any,assign-djs')->name('schedule.assignments.store');
        Route::delete('/schedule/assignments/{id}', [\App\Http\Controllers\Admin\ScheduleController::class, 'destroyAssignment'])->middleware('permission:any,assign-djs')->name('schedule.assignments.destroy');
    });
});
