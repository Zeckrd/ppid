<?php

use Illuminate\Support\Facades\Route;
use App\Models\PermohonanFile;

// User controllers
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PermohonanController as UserPermohonanController;
use App\Http\Controllers\User\KeberatanController;
use App\Http\Controllers\UserSetupController as UserSetupController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\User\Profile\EmailChangeController;

// Admin controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PermohonanController as AdminPermohonanController;
use App\Http\Controllers\Admin\KeberatanController as AdminKeberatanController;

// Auth & system controllers
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;

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

        Route::post('/email/change', [EmailChangeController::class, 'requestChange'])
            ->name('email.change');

        Route::get('/email/change/verify/{token}', [EmailChangeController::class, 'verify'])
            ->name('email.change.verify');
        
    });


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

        // user uploaded single file download (user can only access own)
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

        // Download all as ZIP
        Route::get('/permohonan/{permohonan}/files-zip', [AdminPermohonanController::class, 'downloadAllFilesZip'])
            ->name('permohonan.files.zip');
        
        // Reply file download (admin)
        Route::get('/permohonan/{permohonan}/reply-files/{file}', [AdminPermohonanController::class, 'downloadReplyFile'])
            ->name('permohonan.reply-files.download');

        // Keberatan
        Route::put('/keberatan/{id}', [AdminKeberatanController::class, 'update'])->name('keberatan.update');

        // Reply file download for Keberatan
        Route::get('/permohonan/{permohonan}/keberatan/{keberatan}/reply-file', [AdminKeberatanController::class, 'downloadReplyFile'])
            ->name('keberatan.reply-file.download');


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
