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

Route::get('/sop', function () {
    return view('sop');
});