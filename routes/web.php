<?php

use Illuminate\Support\Facades\Route;

// User controllers
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PermohonanController as UserPermohonanController;
use App\Http\Controllers\User\KeberatanController;

// Admin controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PermohonanController as AdminPermohonanController;

// Auth & system controllers
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Public Routes
Route::view('/', 'user.home');
Route::view('/profil', 'user.profil');
Route::view('/tugas-dan-fungsi', 'user.tugas-dan-fungsi');
Route::view('/surat-keterangan', 'user.surat-keterangan');
Route::view('/sakip', 'user.sakip');
Route::view('/standar-layanan', 'user.standar-layanan');
Route::view('/prosedur-layanan', 'user.prosedur-layanan');
Route::view('/informasi-berkala', 'user.informasi-berkala');
Route::view('/informasi-tersedia-setiap-saat', 'user.informasi-tersedia-setiap-saat');
Route::view('/informasi-dikecualikan', 'user.informasi-dikecualikan');

// Admin Routes
Route::middleware(['auth', 'phone.verified', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard.index');

        // Permohonan
        Route::resource('permohonan', AdminPermohonanController::class)
            ->only(['index', 'show', 'update']);
    });

// User Routes
Route::middleware(['auth', 'phone.verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard.index');

        // Permohonan (user submit & view their own)
        Route::resource('permohonan', UserPermohonanController::class)
            ->except(['index']); // user doesn’t need to see all

        // Keberatan
        Route::resource('keberatan', KeberatanController::class)
            ->only(['show','create','store']);
    });

// Dashboard Routing
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard.index');
    }
    return redirect()->route('user.dashboard.index');
})->middleware(['auth', 'phone.verified'])->name('dashboard');

// Authentication Routes
Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


// Phone Verification
Route::get('/verify-phone/{token}', [PhoneVerificationController::class, 'verify'])->name('verify.phone');



// User Routes (DEBUG)
// Route::middleware(['auth'])
//     ->prefix('user')
//     ->name('user.')
//     ->group(function () {
//         // Dashboard
//         Route::get('/dashboard', [UserDashboardController::class, 'index'])
//             ->name('dashboard.index');

//         // Permohonan (user submit & view their own)
//         Route::resource('permohonan', UserPermohonanController::class)
//             ->except(['index']); // user doesn’t need to see all

//         // Keberatan
//         Route::resource('keberatan', KeberatanController::class)
//             ->only(['show','create','store']);
//     });
