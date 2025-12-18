<?php

use Illuminate\Support\Facades\Route;
use App\Models\PermohonanFile;

// User controllers
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PermohonanController as UserPermohonanController;
use App\Http\Controllers\User\KeberatanController;
use App\Http\Controllers\Auth\UserSetupController as UserSetupController;
use App\Http\Controllers\User\Profile\UserProfileController;
use App\Http\Controllers\User\Profile\EmailChangeController as EmailChangeController;

// Admin controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PermohonanController as AdminPermohonanController;
use App\Http\Controllers\Admin\KeberatanController as AdminKeberatanController;

// Auth & system controllers
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\PhoneVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;

// Public Routes
Route::view('/', 'pages.home');
Route::view('/profil', 'pages.profil');
Route::view('/tugas-dan-fungsi', 'pages.tugas-dan-fungsi');
Route::view('/surat-keterangan', 'pages.surat-keterangan');
Route::view('/sakip', 'pages.sakip');
Route::view('/standar-layanan', 'pages.standar-layanan');
Route::view('/prosedur-layanan', 'pages.prosedur-layanan');
Route::view('/informasi-berkala', 'pages.informasi-berkala');
Route::view('/informasi-tersedia-setiap-saat', 'pages.informasi-tersedia-setiap-saat');
Route::view('/informasi-dikecualikan', 'pages.informasi-dikecualikan');

// UNVERIFIED user routes and basic profile change
Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Setup / Verification Required Page
        Route::get('/setup', [UserSetupController::class, 'index'])
            ->name('setup');

        // Edit Profile (Email, Phone, Name, etc.)
        Route::get('/profile', [UserProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::post('/profile', [UserProfileController::class, 'update'])
            ->name('profile.update');

        Route::post('/profile/password', [UserProfileController::class, 'updatePassword'])
            ->name('profile.password.update');

        Route::post('/profile/phone', [UserProfileController::class, 'updatePhone'])
            ->name('profile.phone.update');

    });

// Email n password change    
Route::middleware(['auth'])
    ->group(function () {

    Route::post('/profile/email-change', [EmailChangeController::class, 'requestChange'])
        ->name('email.change.request');
});
Route::get('/profile/email-change/confirm/{token}', [EmailChangeController::class, 'confirm'])
    ->name('email.change.confirm');

// Verified User Routes
Route::middleware(['auth', 'phone.verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard.index');

        // Permohonan
        Route::resource('permohonan', UserPermohonanController::class)
            ->except(['index']);

        // view user uploaded file
        Route::get('/permohonan/{permohonan}/files/{file}/view', [UserPermohonanController::class, 'viewFile'])
            ->name('permohonan.files.view');
        
        // view (admin) reply file
        Route::get('/permohonan/{permohonan}/reply-files/{file}/view', [UserPermohonanController::class, 'viewReplyFile'])
            ->name('permohonan.reply-files.view');

        // user uploaded download
        Route::get('/permohonan/{permohonan}/files/{file}', [UserPermohonanController::class, 'downloadFile'])
            ->name('permohonan.files.download');
        
        // User download reply files
        Route::get('/permohonan/{permohonan}/reply-files/{file}', [UserPermohonanController::class, 'downloadReplyFile'])
            ->name('permohonan.reply-files.download');

        // Keberatan
        Route::get('/keberatan/show', [KeberatanController::class, 'show'])
            ->name('keberatan.show');

        Route::get('/permohonan/{permohonan}/keberatan/create', [KeberatanController::class, 'create'])
            ->name('keberatan.create');

        Route::post('/permohonan/{permohonan}/keberatan', [KeberatanController::class, 'store'])
            ->name('keberatan.store');

        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/files/{file}', [KeberatanController::class, 'downloadFile'])
            ->name('keberatan.files.download');

        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/reply-files/{file}', [KeberatanController::class, 'downloadReplyFile'])
            ->name('keberatan.reply_files.download');

        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/files/{file}/view',
            [KeberatanController::class, 'viewFile'])
            ->name('keberatan.files.view');

        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/reply-files/{file}/view',
            [KeberatanController::class, 'viewReplyFile'])
            ->name('keberatan.reply_files.view');
    });



// Admin Routes
Route::middleware(['auth', 'phone.verified', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard.index');
        
        Route::get('permohonan/search', [AdminPermohonanController::class, 'search'])->name('permohonan.search');

        // Permohonan
        Route::resource('permohonan', AdminPermohonanController::class)
            ->only(['index', 'show', 'update']);

        // Single file download
        Route::get('/permohonan/{permohonan}/files/{file}', [AdminPermohonanController::class, 'downloadFile'])
            ->name('permohonan.files.download');

        // View file (PDF only, inline)
        Route::get('/permohonan/{permohonan}/files/{file}/view', [AdminPermohonanController::class, 'viewFile'])
            ->name('permohonan.files.view');

        // Download all as ZIP
        Route::get('/permohonan/{permohonan}/files-zip', [AdminPermohonanController::class, 'downloadAllFilesZip'])
            ->name('permohonan.files.zip');
        
        // Reply file download (admin)
        Route::get('/permohonan/{permohonan}/reply-files/{file}', [AdminPermohonanController::class, 'downloadReplyFile'])
            ->name('permohonan.reply-files.download');
        
        // Reply file view (PDF only, inline)
        Route::get('/permohonan/{permohonan}/reply-files/{file}/view', [AdminPermohonanController::class, 'viewReplyFile'])
            ->name('permohonan.reply-files.view');

        // Keberatan
        // Keberatan update
        Route::put('/keberatan/{keberatan}', [AdminKeberatanController::class, 'update'])
            ->name('keberatan.update');

        // User keberatan files (admin side)
        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/files/{file}',
            [AdminKeberatanController::class, 'downloadFile']
        )->name('keberatan.files.download');

        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/files/{file}/view',
            [AdminKeberatanController::class, 'viewFile']
        )->name('keberatan.files.view');

        // Reply files (admin balasan keberatan)
        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/reply-files/{file}',
            [AdminKeberatanController::class, 'downloadReplyFile']
        )->name('keberatan.reply_files.download');

        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/reply-files/{file}/view',
            [AdminKeberatanController::class, 'viewReplyFile']
        )->name('keberatan.reply_files.view');
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
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']) // rate limit 4 in appserviceprovider
    ->middleware('throttle:password-reset')
    ->name('password.email');

Route::get('/reset-password/{token}/{email}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->name('password.update');


// Phone Verification
Route::get('/verify-phone/{token}', [PhoneVerificationController::class, 'verify'])->name('verify.phone');
Route::post('/verify-phone/send', [PhoneVerificationController::class, 'send'])
     ->middleware(['auth'])
     ->name('phone.send');
