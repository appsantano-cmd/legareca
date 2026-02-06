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
use App\Http\Controllers\HalamanVenueController;

// ============================
// PUBLIC ROUTES (NO AUTH)
// ============================
// Public Routes
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
        Route::get('/create', 'create')->name('create');

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

// Kami Daur Routes
Route::get('/kami-daur', [KamiDaurController::class, 'index'])->name('kami-daur.index');

// Lega Pet Care Routes
Route::get('/lega-pet-care', [LegaPetCareController::class, 'index'])->name('lega-pet-care.index');

