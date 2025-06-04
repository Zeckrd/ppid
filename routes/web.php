<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;

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

Route::get('/dashboard', [PermohonanController::class, 'index']);

//Auth
Route::get('/register',[RegisterUserController::class, 'create'])->name('register');
Route::post('/register',[RegisterUserController::class, 'store']);

Route::get('/login',[SessionController::class, 'create'])->name('login');
Route::post('/login',[SessionController::class, 'store']);
Route::post('/logout',[SessionController::class, 'destroy']);