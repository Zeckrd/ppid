<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/tugas-dan-fungsi', function () {
    return view('tugas-dan-fungsi');
});

Route::get('/surat-keterangan', function () {
    return view('surat-keterangan');
});

Route::get('/sakip', function () {
    return view('sakip');
});

Route::get('/standar-layanan', function () {
    return view('standar-layanan');
});

// prosedeur layanan home boxes

Route::get('/prosedur-layanan', function () {
    return view('prosedur-layanan');
});

Route::get('/informasi-berkala', function () {
    return view('informasi-berkala');
});

Route::get('/informasi-tersedia-setiap-saat', function () {
    return view('informasi-tersedia-setiap-saat');
});

Route::get('/informasi-dikecualikan', function () {
    return view('informasi-dikecualikan');
});