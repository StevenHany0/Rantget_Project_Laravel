<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\RenterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HistoriesController;
use App\Http\Controllers\PaymentsController;

// 🔹 Redirect homepage to login if not authenticated
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('auth.login');
});

// 🔹 Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/auth', 'showAuthForm')->name('auth.login'); // الاسم الحالي
    Route::get('/auth', 'showAuthForm')->name('login');       // 👈 السطر الجديد اللي هيحل المشكلة
    Route::post('/login', 'login')->name('login.submit');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'registerafter')->name('register.submit');
    Route::post('/logout', 'logout')->name('logout');
});

// 🔹 Dashboard (Authenticated Users Only)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ Landlord Routes
    Route::prefix('landlord')->name('landlord.')->group(function () {
        Route::get('/dashboard', [LandlordController::class, 'index'])->name('dashboard');
        Route::resource('/properties', PropertiesController::class);
        Route::get('/contracts', [ContractsController::class, 'index'])->name('contracts.index');
        Route::get('/histories', [HistoriesController::class, 'index'])->name('histories.index');
        Route::resource('contracts', ContractsController::class)->names('contracts');


    });

    // ✅ Renter Routes (Fix Applied)
    Route::prefix('renter')->name('renter.')->group(function () {
        Route::get('/dashboard', [RenterController::class, 'index'])->name('dashboard'); // Fixing route
        Route::post('/rent/{property}', [RenterController::class, 'rentProperty'])->name('rent.property');
        Route::get('/rented-properties/{property}', [RenterController::class, 'show'])->name('rented-properties');
    });

    // ✅ Other Routes
    Route::get('/payments/history', [PaymentsController::class, 'history'])->name('payments.history');
});

// 🔹 Public Routes (No Authentication Required)
Route::get('/properties/{property}', [PropertiesController::class, 'show'])->name('properties.show');

// 🔹 Testing Master Layout
Route::get('/master', function () {
    return view('layout.master');
});
