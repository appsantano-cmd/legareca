<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeVipController;

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


Route::get('/screening', [WelcomeVipController::class, 'welcome'])->name('screening.welcome');
Route::get('/screening/agreement', [WelcomeVipController::class, 'agreement'])->name('screening.agreement');

Route::get('/screening/yakin', [WelcomeVipController::class, 'yakin'])->name('screening.yakin');

Route::get('/screening/owner', [WelcomeVipController::class, 'ownerForm'])->name('screening.ownerForm');
Route::post('/screening/owner/submit', [WelcomeVipController::class, 'submitOwner'])->name('screening.submitOwner');

Route::get('/screening/pets', [WelcomeVipController::class, 'petTable'])->name('screening.petTable');
Route::post('/screening/submit-pets', [WelcomeVipController::class, 'submitPets'])->name('screening.submitPets');

Route::get('/screening/result', [WelcomeVipController::class, 'screeningResult'])->name('screening.result');
Route::post('/screening/result/submit', [WelcomeVipController::class, 'submitScreeningResult'])->name('screening.submitResult');

Route::get('/screening/no-hp', [WelcomeVipController::class, 'noHp'])->name('screening.noHp');
Route::post('/screening/no-hp/submit', [WelcomeVipController::class, 'submitNoHp'])->name('screening.submitNoHp');

Route::get('/screening/thankyou', [WelcomeVipController::class, 'thankyou'])->name('screening.thankyou');
