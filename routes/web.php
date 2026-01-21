<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\shiftingController;
use App\Http\Controllers\DailyCleaningReportController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\NotificationPageController;
use App\Http\Controllers\ReservasiController; // TAMBAHKAN INI

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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
    Route::get('/export-sheets', action: [ScreeningController::class, 'exportToSheets'])->name('screening.exportSheets');
});

// Public Pages Routes (Accessible without login)
Route::get('/layanan', function () {
    return view('layanan.index');
})->name('layanan');

Route::get('/agenda', function () {
    return view('agenda.index');
})->name('agenda');

Route::get('/informasi', function () {
    return view('informasi.index');
})->name('informasi');

Route::get('/media', function () {
    return view('media.index');
})->name('media');

Route::get('/profil', function () {
    return view('profil.index');
})->name('profil');

Route::get('/faq', function () {
    return view('faq.index');
})->name('faq');

// Reservasi Routes (Public - bisa diakses tanpa login)
Route::prefix('reservasi')->name('reservasi.')->group(function () {
    // Halaman utama reservasi (landing page)
    Route::get('/', function () {
        return redirect()->route('reservasi.inn.index');
    })->name('index');
    
    // Legareca Inn
    Route::get('/inn', [ReservasiController::class, 'innIndex'])->name('inn.index');
    Route::post('/inn/submit', [ReservasiController::class, 'innSubmit'])->name('inn.submit');
    
    // Jika nanti ada reservasi lain
    // Route::get('/venue', [ReservasiController::class, 'venueIndex'])->name('venue.index');
    // Route::get('/gallery', [ReservasiController::class, 'galleryIndex'])->name('gallery.index');
    // Route::get('/pet', [ReservasiController::class, 'petIndex'])->name('pet.index');
});

// Authentication Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Staff Routes (accessible by all authenticated users)
    // Izin Routes
    Route::prefix('izin')->name('izin.')->group(function () {
        Route::get('/', [PengajuanIzinController::class, 'index'])->name('index');
        Route::get('/create', [PengajuanIzinController::class, 'create'])->name('create');
        Route::post('/', [PengajuanIzinController::class, 'store'])->name('store');
    });

    // shifting Routes
    Route::prefix('shifting')->name('shifting.')->group(function () {
        Route::get('/', [shiftingController::class, 'index'])->name('index');
        Route::post('/submit', [shiftingController::class, 'submit'])->name('submit');
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

    // Admin/Developer Routes (restricted access)
    Route::middleware(['role:developer,admin'])->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store']);
    });

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationPageController::class, 'index'])->name('all');
        Route::post('/{id}/read', [NotificationPageController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationPageController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [NotificationPageController::class, 'destroy'])->name('destroy');
        Route::delete('/', [NotificationPageController::class, 'clearAll'])->name('clear-all');
    });
});