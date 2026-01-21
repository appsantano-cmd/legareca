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
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangKeluarController;

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
    Route::get('/export-sheets', [ScreeningController::class, 'exportToSheets'])
        ->name('export-sheets');
});

// Stock Barang Masuk
Route::prefix('barang-masuk')->name('barang-masuk.')->group(function () {
    // Halaman Utama (hanya data aktif)
    Route::get('/', [BarangMasukController::class, 'index'])->name('index');

    // Trash management
    Route::get('/trash', [BarangMasukController::class, 'trash'])->name('trash');

    // Data endpoints - PERBAIKAN DI SINI
    Route::get('/get-barang-data', [BarangMasukController::class, 'getBarangData'])->name('get-barang-data');
    Route::get('/get-satuan-data', [BarangMasukController::class, 'getSatuanData'])->name('get-satuan-data'); // PERBAIKAN

    // Restore operations
    Route::post('/{id}/restore', [BarangMasukController::class, 'restore'])->name('restore');
    Route::post('/restore-all', [BarangMasukController::class, 'restoreAll'])->name('restore.all');
    Route::delete('/{id}/force-delete', [BarangMasukController::class, 'forceDelete'])->name('force.delete');
    Route::delete('/empty-trash', [BarangMasukController::class, 'emptyTrash'])->name('empty.trash');

    // CRUD operations
    Route::post('/store-multiple', [BarangMasukController::class, 'storeMultiple'])->name('store.multiple');
    Route::get('/{barangMasuk}/edit', [BarangMasukController::class, 'edit'])->name('edit');
    Route::put('/{barangMasuk}', [BarangMasukController::class, 'update'])->name('update');
    Route::delete('/{barangMasuk}', [BarangMasukController::class, 'destroy'])->name('destroy');

    // API Routes
    Route::get('/api/suppliers', [BarangMasukController::class, 'getSuppliers'])->name('api.suppliers');
    Route::get('/api/barang', [BarangMasukController::class, 'getBarang'])->name('api.barang');

    // Sheet
    Route::post('/export-sheets', [BarangMasukController::class, 'exportToSheets'])->name('export-sheets');
});

// Barang 
Route::prefix('barang')->name('barang.')->group(function () {
    Route::get('/', [BarangController::class, 'index'])->name('index');
    Route::get('/create', [BarangController::class, 'create'])->name('create');
    Route::get('/trash', [BarangController::class, 'trash'])->name('trash');

    Route::post('/', [BarangController::class, 'store'])->name('store');
    Route::post('/store-multiple', [BarangController::class, 'storeMultiple'])->name('store.multiple');
    Route::get('/{id}', [BarangController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BarangController::class, 'update'])->name('update');
    Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');

    // Trash Management
    Route::post('/{id}/restore', [BarangController::class, 'restore'])->name('restore');
    Route::post('/restore-all', [BarangController::class, 'restoreAll'])->name('restore.all');
    Route::delete('/{id}/force-delete', [BarangController::class, 'forceDelete'])->name('force.delete');
    Route::delete('/empty-trash', [BarangController::class, 'emptyTrash'])->name('empty.trash');

    // API Routes
    Route::get('/api/list', [BarangController::class, 'getBarangList'])->name('api.list');
    Route::post('/api/check-kode', [BarangController::class, 'checkKodeBarang'])->name('api.check.kode');
    Route::post('/api/generate-kode', [BarangController::class, 'generateKode'])->name('api.generate');
});

// Satuan
Route::resource('satuan', SatuanController::class);
Route::get('/api/satuans', [SatuanController::class, 'apiIndex'])->name('api.satuans');

// Barang Keluar Routes
Route::prefix('barang-keluar')->group(function () {
    Route::get('/', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
    Route::get('/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
    Route::post('/', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
    Route::get('/{id}', [BarangKeluarController::class, 'show'])->name('barang-keluar.show');
    Route::get('/{id}/edit', [BarangKeluarController::class, 'edit'])->name('barang-keluar.edit');
    Route::put('/{id}', [BarangKeluarController::class, 'update'])->name('barang-keluar.update');
    Route::delete('/{id}', [BarangKeluarController::class, 'destroy'])->name('barang-keluar.destroy');

    // Custom routes
    Route::get('/trash', [BarangKeluarController::class, 'trash'])->name('barang-keluar.trash');
    Route::post('/restore/{id}', [BarangKeluarController::class, 'restore'])->name('barang-keluar.restore');
    Route::delete('/force-delete/{id}', [BarangKeluarController::class, 'forceDelete'])->name('barang-keluar.force-delete');
    Route::post('/export-to-sheets', [BarangKeluarController::class, 'exportToSheets'])->name('barang-keluar.export-to-sheets');
});

// API Routes untuk modal (tanpa auth)
Route::prefix('api/barang-keluar')->group(function () {
    Route::get('/barang-list', [BarangKeluarController::class, 'getBarangList']);
    Route::get('/barang/{id}', [BarangKeluarController::class, 'getBarangDetail']);
    Route::get('/satuan-list', [BarangKeluarController::class, 'getSatuanList']);
    Route::get('/satuan/{id}', [BarangKeluarController::class, 'getSatuanDetail']);
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