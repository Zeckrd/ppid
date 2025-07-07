<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Middleware\CheckPhoneVerified;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::view('/', 'home');
Route::view('/profil', 'profil');
Route::view('/tugas-dan-fungsi', 'tugas-dan-fungsi');
Route::view('/surat-keterangan', 'surat-keterangan');
Route::view('/sakip', 'sakip');
Route::view('/standar-layanan', 'standar-layanan');
Route::view('/prosedur-layanan', 'prosedur-layanan');
Route::view('/informasi-berkala', 'informasi-berkala');
Route::view('/informasi-tersedia-setiap-saat', 'informasi-tersedia-setiap-saat');
Route::view('/informasi-dikecualikan', 'informasi-dikecualikan');

// //dashboard
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::middleware(['auth', CheckPhoneVerified::class])->group(function () {
//     Route::get('/dashboard/create', [DashboardController::class, 'create'])->name('dashboard.create');
// });

Route::middleware(['auth', 'phone.verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/create', [DashboardController::class, 'create'])->name('dashboard.create');
    Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::get('/dashboard/permohonan/{permohonan}', [DashboardController::class, 'show'])->name('dashboard.show')->middleware('can:view,permohonan');
    Route::get('/dashboard/permohonan/{permohonan}/edit', [DashboardController::class, 'edit'])->name('dashboard.edit')->middleware('can:update,permohonan');
    Route::put('/dashboard/permohonan/{permohonan}', [DashboardController::class, 'update'])->name('dashboard.update')->middleware('can:update,permohonan');
});

//Auth
Route::get('/register',[RegisterUserController::class, 'create'])->name('register');
Route::post('/register',[RegisterUserController::class, 'store']);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/login',[SessionController::class, 'create'])->name('login');
Route::post('/login',[SessionController::class, 'store']);
Route::post('/logout',[SessionController::class, 'destroy']);

//phone and email verification
Route::get('/verify-phone/{token}', [PhoneVerificationController::class, 'verify'])->name('verify.phone');