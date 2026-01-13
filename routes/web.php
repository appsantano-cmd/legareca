<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\SiftingController;
use App\Http\Controllers\DailyCleaningReportController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authentication Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Staff Routes (accessible by all authenticated users)
    Route::middleware('auth')->group(function () {
        // Izin Routes
        Route::prefix('izin')->name('izin.')->group(function () {
            Route::get('/', [PengajuanIzinController::class, 'index'])->name('index');
            Route::get('/create', [PengajuanIzinController::class, 'create'])->name('create');
            Route::post('/', [PengajuanIzinController::class, 'store'])->name('store');
        });

        // Sifting Routes
        Route::prefix('sifting')->name('sifting.')->group(function () {
            Route::get('/', [SiftingController::class, 'index'])->name('index');
            Route::post('/submit', [SiftingController::class, 'submit'])->name('submit');
        });

        // Daily Cleaning Report Routes
        Route::prefix('cleaning-report')->name('cleaning-report.')->group(function () {
            // Main Routes
            Route::get('/', [DailyCleaningReportController::class, 'index'])->name('index');

            // Multi-step Form
            Route::get('/create', [DailyCleaningReportController::class, 'create'])->name('create');
            Route::post('/store-step1', [DailyCleaningReportController::class, 'storeStep1'])->name('storeStep1');

            Route::get('/step2', [DailyCleaningReportController::class, 'showStep2'])->name('step2');
            Route::post('/store-step2', [DailyCleaningReportController::class, 'storeStep2'])->name('storeStep2');

            Route::get('/complete/{id}', [DailyCleaningReportController::class, 'complete'])->name('complete');

            // Google Sheets Integration
            Route::get('/export/google-sheets', [DailyCleaningReportController::class, 'exportAllToGoogleSheets'])
                ->name('export.google-sheets');

            Route::get('/test-google-sheets', [DailyCleaningReportController::class, 'testGoogleSheetsConnection'])
                ->name('test-google-sheets');

            Route::get('/check-config', [DailyCleaningReportController::class, 'checkGoogleSheetsConfig'])
                ->name('check-config');
        });
    });

    // Admin/Developer Routes (restricted access)
    Route::middleware(['role:developer,admin'])->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store']);

        // Screening Routes
        Route::prefix('screening')->name('screening.')->group(function () {
            Route::get('/', [ScreeningController::class, 'welcome'])->name('welcome');
            Route::get('/agreement', [ScreeningController::class, 'agreement'])->name('agreement');
            Route::get('/yakin', [ScreeningController::class, 'yakin'])->name('yakin');
            Route::get('/owner', [ScreeningController::class, 'ownerForm'])->name('ownerForm');
            Route::post('/owner/submit', [ScreeningController::class, 'submitOwner'])->name('submitOwner');
            Route::get('/pets', [ScreeningController::class, 'petTable'])->name('petTable');
            Route::post('/submit-pets', [ScreeningController::class, 'submitPets'])->name('submitPets');
            Route::get('/result', [ScreeningController::class, 'screeningResult'])->name('result');
            Route::post('/result/submit', [ScreeningController::class, 'submitScreeningResult'])->name('submitResult');
            Route::get('/no-hp', [ScreeningController::class, 'noHp'])->name('noHp');
            Route::post('/no-hp/submit', [ScreeningController::class, 'submitNoHp'])->name('submitNoHp');
            Route::get('/thankyou', [ScreeningController::class, 'thankyou'])->name('thankyou');
            Route::get('/cancelled', [ScreeningController::class, 'cancelled'])->name('cancelled');
        });
    });
});

// Public Screening Export Route (if needed without authentication)
Route::get('/export-sheets', [ScreeningController::class, 'exportToSheets'])->name('screening.exportSheets');