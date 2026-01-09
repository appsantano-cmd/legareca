<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeVipController;
use App\Http\Controllers\SiftingController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * SIFTING (PUBLIC – tanpa login)
 */
Route::prefix('sifting')->name('sifting.')->group(function () {
    Route::get('/', [SiftingController::class, 'index'])->name('index');
    Route::post('/submit', [SiftingController::class, 'submit'])->name('submit');
});

/**
 * AUTH
 */
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /**
     * SIFTING MANAGEMENT (ADMIN / INTERNAL)
     */
    Route::prefix('sifting')->name('sifting.')->group(function () {

        Route::get('/requests', [SiftingController::class, 'requests'])
            ->name('requests');

        Route::get('/requests/{id}', [SiftingController::class, 'show'])
            ->name('show');

        Route::post('/requests/{id}/status', [SiftingController::class, 'updateStatus'])
            ->name('updateStatus');

        Route::get('/statistics', [SiftingController::class, 'statistics'])
            ->name('statistics');

        Route::get('/export', [SiftingController::class, 'export'])
            ->name('export');
    });
});


/*
|--------------------------------------------------------------------------
| ADMIN ONLY ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:developer,admin'])->group(function () {

    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store']);
});


/*
|--------------------------------------------------------------------------
| SCREENING MODULE
|--------------------------------------------------------------------------
*/
Route::prefix('screening')->name('screening.')->group(function () {

    Route::get('/', [WelcomeVipController::class, 'welcome'])
        ->name('welcome');

    Route::get('/agreement', [WelcomeVipController::class, 'agreement'])
        ->name('agreement');

    Route::get('/form', [WelcomeVipController::class, 'ownerForm'])
        ->name('ownerForm');

    Route::post('/form/submit', [WelcomeVipController::class, 'submitOwner'])
        ->name('submitOwner');

    Route::get('/pets', [WelcomeVipController::class, 'petTable'])
        ->name('petTable');

    Route::post('/pets/submit', [WelcomeVipController::class, 'submitPets'])
        ->name('submitPets');

    Route::post('/result/submit', [WelcomeVipController::class, 'submitScreeningResult'])
        ->name('submitResult');

    Route::get('/result', [WelcomeVipController::class, 'screeningResult'])
        ->name('result');
});
