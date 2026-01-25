<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\shiftingController;
use App\Http\Controllers\DailyCleaningReportController;
use App\Http\Controllers\NotificationPageController;
use App\Http\Controllers\ArtGalleryController;
use App\Http\Controllers\StokGudangController;
use App\Http\Controllers\StokTransactionController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\DepartemenController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/art-gallery', [ArtGalleryController::class, 'index'])
    ->name('gallery.index');

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
    Route::get('/export-sheets', [ScreeningController::class, 'exportToSheets'])
        ->name('export-sheets');
});

//Notification
Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationPageController::class, 'index'])->name('notifications.all');
    Route::post('/{id}/read', [NotificationPageController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/read-all', [NotificationPageController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/{id}', [NotificationPageController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/', [NotificationPageController::class, 'clearAll'])->name('notifications.clear-all');
});

Route::resource('departemen', DepartemenController::class)
    ->parameters(['departemen' => 'departemen']);

Route::resource('satuan', SatuanController::class);
// Route API untuk mengambil data satuan dalam format JSON
Route::get('/api/satuan', [SatuanController::class, 'indexApi'])->name('api.satuan.index');

// Route untuk stok gudang
Route::prefix('stok-gudang')->name('stok.')->group(function () {
    Route::get('/', [StokGudangController::class, 'index'])->name('index');
    Route::get('/create', [StokGudangController::class, 'create'])->name('create');
    Route::post('/', [StokGudangController::class, 'store'])->name('store');

    // Tambahkan routes untuk edit, update, dan destroy
    Route::get('/{id}/edit', [StokGudangController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StokGudangController::class, 'update'])->name('update');
    Route::delete('/{id}', [StokGudangController::class, 'destroy'])->name('destroy');

    Route::post('/rollover', [StokGudangController::class, 'rollover'])->name('rollover');
    Route::get('/export', [StokGudangController::class, 'exportExcel'])->name('export');
    Route::get('/rollover-history', [StokGudangController::class, 'showRolloverHistory'])->name('rollover.history');
});

// Route untuk transaksi harian
Route::prefix('transactions')->name('transactions.')->group(function () {

    Route::get('/', [StokTransactionController::class, 'index'])->name('index');
    Route::get('/create', [StokTransactionController::class, 'create'])->name('create');
    Route::post('/', [StokTransactionController::class, 'store'])->name('store');


    // Tambahkan route edit, update, dan destroy
    Route::get('/{transaction}/edit', [StokTransactionController::class, 'edit'])->name('edit');
    Route::put('/{transaction}', [StokTransactionController::class, 'update'])->name('update');
    Route::delete('/{transaction}', [StokTransactionController::class, 'destroy'])->name('destroy');

    Route::get('/{id}', [StokTransactionController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('show');

});

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
    });

    // Admin/Developer Routes (restricted access)
    Route::middleware(['role:developer,admin'])->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store']);
    });

    //Notification
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationPageController::class, 'index'])->name('notifications.all');
        Route::post('/{id}/read', [NotificationPageController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/read-all', [NotificationPageController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::delete('/{id}', [NotificationPageController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/', [NotificationPageController::class, 'clearAll'])->name('notifications.clear-all');
    });
});