<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\ShiftingController;
use App\Http\Controllers\DailyCleaningReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:developer,admin'])->group(function () {
    Route::resource('users', UserController::class)
        ->only(['index', 'create', 'store']);
});

Route::prefix('izin')->name('izin.')->group(function () {
    Route::get('/', [PengajuanIzinController::class, 'index'])
        ->name('index');

    Route::get('/create', [PengajuanIzinController::class, 'create'])
        ->name('create');

    Route::post('/', [PengajuanIzinController::class, 'store'])
        ->name('store');
});

// Screening
Route::get('/screening', [ScreeningController::class, 'welcome'])->name('screening.welcome');
Route::get('/screening/agreement', [ScreeningController::class, 'agreement'])->name('screening.agreement');

Route::get('/screening/yakin', [ScreeningController::class, 'yakin'])->name('screening.yakin');

Route::get('/screening/owner', [ScreeningController::class, 'ownerForm'])->name('screening.ownerForm');
Route::post('/screening/owner/submit', [ScreeningController::class, 'submitOwner'])->name('screening.submitOwner');

Route::get('/screening/pets', [ScreeningController::class, 'petTable'])->name('screening.petTable');
Route::post('/screening/submit-pets', [ScreeningController::class, 'submitPets'])->name('screening.submitPets');

Route::get('/screening/result', [ScreeningController::class, 'screeningResult'])->name('screening.result');
Route::post('/screening/result/submit', [ScreeningController::class, 'submitScreeningResult'])->name('screening.submitResult');

Route::get('/screening/no-hp', [ScreeningController::class, 'noHp'])->name('screening.noHp');
Route::post('/screening/no-hp/submit', [ScreeningController::class, 'submitNoHp'])->name('screening.submitNoHp');

Route::get('/screening/thankyou', [ScreeningController::class, 'thankyou'])->name('screening.thankyou');

Route::get('/export-sheets', [ScreeningController::class, 'exportToSheets'])->name('screening.exportSheets');

Route::get('/screening/cancelled', [ScreeningController::class, 'cancelled'])->name('screening.cancelled');

Route::prefix('shifting')->name('shifting.')->group(function () {

    Route::get('/', [ShiftingController::class, 'index'])
        ->name('index');

    Route::post('/submit', [ShiftingController::class, 'submit'])
        ->name('submit');

});
// Routes untuk Daily Cleaning Report
Route::prefix('cleaning-report')->group(function () {
    // Step 1
    Route::get('/create', [DailyCleaningReportController::class, 'create'])
        ->name('cleaning-report.create');

    Route::post('/store-step1', [DailyCleaningReportController::class, 'storeStep1'])
        ->name('cleaning-report.storeStep1');

    // Step 2
    Route::get('/step2', [DailyCleaningReportController::class, 'showStep2'])
        ->name('cleaning-report.step2');

    Route::post('/store-step2', [DailyCleaningReportController::class, 'storeStep2'])
        ->name('cleaning-report.storeStep2');

    // Complete
    Route::get('/complete/{id}', [DailyCleaningReportController::class, 'complete'])
        ->name('cleaning-report.complete');

    // Index - redirect ke create (hanya untuk menghindari error)
    Route::get('/', [DailyCleaningReportController::class, 'index'])
        ->name('cleaning-report.index');

    // Google Sheets Routes - Redirect ke complete page
    Route::get('/export/google-sheets', [DailyCleaningReportController::class, 'exportAllToGoogleSheets'])
        ->name('cleaning-report.export.google-sheets');

    Route::get('/test-google-sheets', [DailyCleaningReportController::class, 'testGoogleSheetsConnection'])
        ->name('cleaning-report.test-google-sheets');
    Route::get('/cleaning-report/check-config', [DailyCleaningReportController::class, 'checkGoogleSheetsConfig']);
    Route::get('/cleaning-report/test-google-sheets', [DailyCleaningReportController::class, 'testGoogleSheetsConnection']);
    Route::get('/cleaning-report/export/google-sheets', [DailyCleaningReportController::class, 'exportAllToGoogleSheets'])
        ->name('cleaning-report.export.google-sheets');

    //Route::get('/cleaning-report/simple-test', [DailyCleaningReportController::class, 'simpleTest']);
    //Route::get('/cleaning-report/test-connection', [DailyCleaningReportController::class, 'testConnection']);
});
