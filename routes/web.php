<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\ShiftingController;
use App\Http\Controllers\DailyCleaningReportController;
use App\Http\Controllers\NotificationPageController;
use App\Http\Controllers\ArtGalleryController;
use App\Http\Controllers\StokGudangController;
use App\Http\Controllers\StokTransactionController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\VenueBookingController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\CafeRestoController;
use App\Http\Controllers\KamiDaurController;
use App\Http\Controllers\LegaPetCareController;
use App\Http\Controllers\SatuanStationController;
use App\Http\Controllers\StokStationMasterKitchenController;
use App\Http\Controllers\StokStationMasterBarController;
use App\Http\Controllers\StokKitchenController;
use App\Http\Controllers\StokBarController;

// ============================
// PUBLIC ROUTES (NO AUTH)
// ============================

// Home
Route::get('/', function () {
    return view('welcome.welcome');
});

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Art Gallery (Public)
Route::controller(ArtGalleryController::class)->group(function () {
    Route::get('/art-gallery', 'index')->name('gallery.index');
    Route::get('/art-gallery/{art}', 'show')->name('gallery.show');
});

// Screening
Route::prefix('screening')->name('screening.')->controller(ScreeningController::class)->group(function () {
    Route::get('/', 'welcome')->name('welcome');
    Route::get('/agreement', 'agreement')->name('agreement');
    Route::get('/yakin', 'yakin')->name('yakin');
    Route::get('/owner', 'ownerForm')->name('ownerForm');
    Route::post('/owner/submit', 'submitOwner')->name('submitOwner');
    Route::get('/pets', 'petTable')->name('petTable');
    Route::post('/submit-pets', 'submitPets')->name('submitPets');
    Route::get('/result', 'screeningResult')->name('result');
    Route::post('/result/submit', 'submitScreeningResult')->name('submitResult');
    Route::get('/no-hp', 'noHp')->name('noHp');
    Route::post('/no-hp/submit', 'submitNoHp')->name('submitNoHp');
    Route::get('/thankyou', 'thankyou')->name('thankyou');
    Route::get('/review-data', 'reviewData')->name('review-data');
    Route::get('/cancelled', 'cancelled')->name('cancelled');
    Route::get('/export-sheets', 'exportToSheets')->name('export-sheets');
    Route::get('/export', 'export')->name('export');
    
    // Admin Screening Data
    Route::middleware(['auth'])->group(function () {
        Route::get('/data', 'index')->name('index');
        Route::get('/data/{id}', 'show')->name('show');
        Route::delete('/data/{id}', 'destroy')->name('destroy');
    });
});

// Venue Booking
Route::controller(VenueBookingController::class)->group(function () {
    Route::get('/venue', 'index')->name('venue.index');
    Route::post('/venue/step', 'handleStep')->name('venue.step');
    Route::post('/venue/submit', 'submitBooking')->name('venue.submit');
});

// Cafe & Resto
Route::controller(CafeRestoController::class)->group(function () {
    Route::get('/cafe-resto', 'index')->name('cafe-resto');
    Route::post('/cafe-resto/reservation', 'store')->name('cafe-resto.reservation.store');
});

// Business Units
Route::controller(KamiDaurController::class)->group(function () {
    Route::get('/kami-daur', 'index')->name('kami-daur.index');
});

Route::controller(LegaPetCareController::class)->group(function () {
    Route::get('/lega-pet-care', 'index')->name('lega-pet-care.index');
});

// Reservasi
Route::prefix('reservasi')->name('reservasi.')->controller(ReservasiController::class)->group(function () {
    Route::get('/', function () {
        return redirect()->route('reservasi.inn.index');
    })->name('index');
    
    Route::get('/inn', 'innIndex')->name('inn.index');
    Route::post('/inn/submit', 'innSubmit')->name('inn.submit');
});

// Static Pages
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

// ============================
// AUTHENTICATED ROUTES (ALL ROLES)
// ============================
Route::middleware(['auth', 'role:developer,admin,marcom,staff'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Stok Station Dashboard
    Route::get('/stok-station', [DashboardController::class, 'index'])->name('home');

    // Izin
    Route::prefix('izin')->name('izin.')->controller(PengajuanIzinController::class)->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });

    // Shifting
    Route::prefix('shifting')->name('shifting.')->controller(ShiftingController::class)->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/submit', 'submit')->name('submit');
    });

    // Daily Cleaning Report
    Route::prefix('cleaning-report')->name('cleaning-report.')->controller(DailyCleaningReportController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
    });

    // Cleaning Report Data
    Route::prefix('data')->name('data.')->controller(DailyCleaningReportController::class)->group(function () {
        Route::post('/store-step1', 'storeStep1')->name('storeStep1');
        Route::get('/step2', 'showStep2')->name('step2');
        Route::post('/store-step2', 'storeStep2')->name('storeStep2');
        Route::get('/complete/{id}', 'complete')->name('complete');
        
        // Google Sheets Integration
        Route::get('/export/google-sheets', 'exportAllToGoogleSheets')->name('export.google-sheets');
        Route::get('/test-google-sheets', 'testGoogleSheetsConnection')->name('test.google-sheets');
        Route::get('/check-config', 'checkGoogleSheetsConfig')->name('check.config');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->controller(NotificationPageController::class)->group(function () {
        Route::get('/', 'index')->name('all');
        Route::post('/{id}/read', 'markAsRead')->name('read');
        Route::post('/read-all', 'markAllAsRead')->name('read-all');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::delete('/', 'clearAll')->name('clear-all');
    });

    // Stok Station
    Route::resource('stok-kitchen', StokKitchenController::class)->except(['create', 'edit', 'show']);
    Route::resource('stok-bar', StokBarController::class)->except(['create', 'edit', 'show']);

    // Stok Station APIs
    Route::get('/api/master-kitchen/{kode_bahan}', [StokKitchenController::class, 'getMasterBahan']);
    Route::get('/api/master-bar/{kode_bahan}', [StokBarController::class, 'getMasterBahan']);
    Route::get('/api/previous-stok-kitchen', [StokKitchenController::class, 'getPreviousStok']);
    Route::get('/api/previous-stok-bar', [StokBarController::class, 'getPreviousStok']);

    // Transactions
    Route::prefix('transactions')->name('transactions.')->controller(StokTransactionController::class)->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/get-barang-by-departemen', 'getBarangByDepartemen')->name('getBarangByDepartemen');
    });

    // Art Gallery (Authenticated)
    Route::controller(ArtGalleryController::class)->group(function () {
        Route::get('/art-gallery/pages/create', 'create')->name('gallery.create');
        Route::post('/art-gallery', 'store')->name('gallery.store');
    });
});

// ============================
// ADMIN/DEVELOPER ROUTES
// ============================
Route::middleware(['auth', 'role:developer,admin'])->group(function () {

    // User Management
    Route::resource('users', UserController::class)->only(['index', 'create', 'store']);

    // Stok Gudang
    Route::prefix('stok-gudang')->name('stok.')->controller(StokGudangController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/rollover', 'rollover')->name('rollover');
        Route::get('/rollover-history', 'showRolloverHistory')->name('rollover.history');
        Route::get('/export', 'exportExcel')->name('export');
    });

    // Stok Gudang Transactions
    Route::prefix('transactions')->name('transactions.')->controller(StokTransactionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{transaction}/edit', 'edit')->name('edit');
        Route::put('/{transaction}', 'update')->name('update');
        Route::delete('/{transaction}', 'destroy')->name('destroy');
        Route::get('/{id}', 'show')->where('id', '[0-9]+')->name('show');
        Route::get('/export', 'showExportForm')->name('export.form');
        Route::post('/export', 'export')->name('export');
    });

    // Stok Gudang Master Data
    Route::resource('departemen', DepartemenController::class)->parameters(['departemen' => 'departemen']);
    Route::get('/api/departemen', [DepartemenController::class, 'indexApi'])->name('api.departemen.index');
    
    Route::resource('satuan', SatuanController::class);
    Route::get('/api/satuan', [SatuanController::class, 'indexApi'])->name('api.satuan.index');

    // Supplier
    Route::prefix('supplier')->name('supplier.')->controller(SupplierController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{supplier}/edit', 'edit')->name('edit');
        Route::put('/{supplier}', 'update')->name('update');
        Route::delete('/{supplier}', 'destroy')->name('destroy');
        Route::put('/{id}/restore', 'restore')->name('restore');
        Route::get('/api/supplier', 'indexApi')->name('api.supplier.index');
    });

    // Stok Station Master Data
    Route::resource('master-kitchen', StokStationMasterKitchenController::class)->except(['show', 'create', 'edit']);
    Route::resource('satuan-station', SatuanStationController::class)->except(['show']);
    Route::resource('master-bar', StokStationMasterBarController::class)->except(['show', 'create', 'edit']);

    // Izin Management
    Route::prefix('izin')->name('izin.')->controller(PengajuanIzinController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/update-status', 'updateStatus')->name('update-status');
        Route::get('/export', 'export')->name('export');
        Route::get('/email-action/{id}', 'actionFromEmail')->name('email-action');
        Route::get('/{id}/detail', 'detail')->name('detail');
    });

    // Shifting Management
    Route::prefix('shifting')->name('shifting.')->controller(ShiftingController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/export', 'export')->name('export');
        Route::get('/{id}/detail', 'detail')->name('detail');
        Route::post('/{id}/update-status', 'updateStatus')->name('update-status');
        Route::get('/{id}/update-status', function ($id) {
            return redirect()->route('shifting.index')
                ->with('error', 'Akses tidak valid. Silakan gunakan tombol di tabel.');
        });
        Route::get('/email-action/{id}', 'actionFromEmail')->name('email-action');
    });

    // Cleaning Report Management
    Route::prefix('cleaning-report')->name('cleaning-report.')->controller(DailyCleaningReportController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
    });

    // Cleaning Report Data Management
    Route::prefix('data')->name('data')->controller(DailyCleaningReportController::class)->group(function () {
        Route::get('/', 'getData')->name('get');
        Route::post('/update', 'updateData')->name('update');
        Route::post('/clean', 'cleanData')->name('clean');
        Route::post('/delete', 'deleteData')->name('delete');
        Route::get('/export', 'exportData')->name('export');
        Route::get('/stats', 'getStats')->name('stats');
    });
});