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

// Public Routes
Route::get('/', function () {
    return view('welcome.welcome');
});

// Route yang bisa diakses UMUM (tanpa login)
Route::get('/art-gallery', [ArtGalleryController::class, 'index'])
    ->name('gallery.index');

Route::get('/art-gallery/{art}', [ArtGalleryController::class, 'show'])
    ->name('gallery.show');

// Route yang membutuhkan LOGIN (admin area)
Route::middleware(['auth'])->group(function () {
    Route::get('/art-gallery/pages/create', [ArtGalleryController::class, 'create']) // TANPA /pages
        ->name('gallery.create');

    Route::post('/art-gallery', [ArtGalleryController::class, 'store'])
        ->name('gallery.store');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Screening Routes
Route::prefix('screening')->name('screening.')->group(function () {
    Route::get('/data', [ScreeningController::class, 'index'])->name('index');
    Route::get('/data/{id}', [ScreeningController::class, 'show'])->name('show');
    Route::delete('/data/{id}', [ScreeningController::class, 'destroy'])->name('destroy');
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
    Route::post('/data/export', [ScreeningController::class, 'export'])->name('export');
});

// Notification Routes (Public)
Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationPageController::class, 'index'])->name('all');
    Route::post('/{id}/read', [NotificationPageController::class, 'markAsRead'])->name('read');
    Route::post('/read-all', [NotificationPageController::class, 'markAllAsRead'])->name('read-all');
    Route::delete('/{id}', [NotificationPageController::class, 'destroy'])->name('destroy');
    Route::delete('/', [NotificationPageController::class, 'clearAll'])->name('clear-all');
});

// =======================
// STOK GUDANG - AUTH
// =======================
Route::middleware('auth')->prefix('stok-gudang')->name('stok.')->group(function () {
    Route::get('/create', [StokGudangController::class, 'create'])->name('create');
    Route::post('/', [StokGudangController::class, 'store'])->name('store');
    Route::get('/', [StokGudangController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [StokGudangController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StokGudangController::class, 'update'])->name('update');
    Route::delete('/{id}', [StokGudangController::class, 'destroy'])->name('destroy');

    Route::post('/rollover', [StokGudangController::class, 'rollover'])->name('rollover');
    Route::get('/export', [StokGudangController::class, 'exportExcel'])->name('export');
    Route::get('/rollover-history', [StokGudangController::class, 'showRolloverHistory'])->name('rollover.history');
});

// =======================
// TRANSACTIONS - PUBLIC
// =======================
Route::prefix('transactions')->name('transactions.')->group(function () {
    Route::get('/create', [StokTransactionController::class, 'create'])->name('create');
    Route::post('/', [StokTransactionController::class, 'store'])->name('store');
});

// =======================
// TRANSACTIONS - AUTH
// =======================
Route::middleware('auth')->prefix('transactions')->name('transactions.')->group(function () {
    Route::get('/', [StokTransactionController::class, 'index'])->name('index');

    Route::get('/{transaction}/edit', [StokTransactionController::class, 'edit'])->name('edit');
    Route::put('/{transaction}', [StokTransactionController::class, 'update'])->name('update');
    Route::delete('/{transaction}', [StokTransactionController::class, 'destroy'])->name('destroy');

    Route::get('/{id}', [StokTransactionController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('show');
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

    // Departemen
    Route::resource('departemen', DepartemenController::class)
        ->parameters(['departemen' => 'departemen']);
    Route::get('/api/departemen', [DepartemenController::class, 'indexApi'])->name('api.departemen.index');

    // Satuan
    Route::resource('satuan', SatuanController::class);
    Route::get('/api/satuan', [SatuanController::class, 'indexApi'])->name('api.satuan.index');

    // Supplier
    Route::prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/', [SupplierController::class, 'store'])->name('store');
        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/restore', [SupplierController::class, 'restore'])->name('restore');

        Route::get('/api/supplier', [SupplierController::class, 'indexApi'])->name('api.supplier.index');
    });

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
        Route::get('/', [ShiftingController::class, 'index'])->name('index');
        Route::get('/create', [ShiftingController::class, 'create'])->name('create');
        Route::post('/submit', [ShiftingController::class, 'submit'])->name('submit');
    });

    // Daily Cleaning Report Routes
    Route::prefix('cleaning-report')->name('cleaning-report.')->group(function () {
        // ===== ROUTE UNTUK FORM INPUT DATA BARU =====
        Route::get('/', [DailyCleaningReportController::class, 'index'])->name('index');
        Route::get('/create', [DailyCleaningReportController::class, 'create'])->name('create'); // TAMBAHKAN INI

        // ===== ROUTE UNTUK DASHBOARD =====
        Route::get('/dashboard', [DailyCleaningReportController::class, 'dashboard'])->name('dashboard');

        // ===== ROUTE UNTUK DATA API (AJAX) =====
        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/', [DailyCleaningReportController::class, 'getData'])->name('get');
            Route::post('/update', [DailyCleaningReportController::class, 'updateData'])->name('update');
            Route::post('/clean', [DailyCleaningReportController::class, 'cleanData'])->name('clean');
            Route::post('/delete', [DailyCleaningReportController::class, 'deleteData'])->name('delete');
            Route::get('/export', [DailyCleaningReportController::class, 'exportData'])->name('export');
            Route::get('/stats', [DailyCleaningReportController::class, 'getStats'])->name('stats');
        });

        // ===== ROUTE UNTUK MULTI-STEP FORM =====
        Route::post('/store-step1', [DailyCleaningReportController::class, 'storeStep1'])->name('storeStep1');
        Route::get('/step2', [DailyCleaningReportController::class, 'showStep2'])->name('step2');
        Route::post('/store-step2', [DailyCleaningReportController::class, 'storeStep2'])->name('storeStep2');
        Route::get('/complete/{id}', [DailyCleaningReportController::class, 'complete'])->name('complete');

        // ===== GOOGLE SHEETS INTEGRATION =====
        Route::get('/export/google-sheets', [DailyCleaningReportController::class, 'exportAllToGoogleSheets'])
            ->name('export.google-sheets');
        Route::get('/test-google-sheets', [DailyCleaningReportController::class, 'testGoogleSheetsConnection'])
            ->name('test.google-sheets');
        Route::get('/check-config', [DailyCleaningReportController::class, 'checkGoogleSheetsConfig'])
            ->name('check.config');
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

    // Venue Booking Routes

    Route::get('/venue', [VenueBookingController::class, 'index'])->name('venue.index');
    Route::post('/venue/step', [VenueBookingController::class, 'handleStep'])->name('venue.step');
    Route::post('/venue/submit', [VenueBookingController::class, 'submitBooking'])->name('venue.submit');
});

// Cafe & Resto Routes
Route::get('/cafe-resto', [CafeRestoController::class, 'index'])->name('cafe-resto');
Route::post('/cafe-resto/reservation', [CafeRestoController::class, 'store'])->name('cafe-resto.reservation.store');
