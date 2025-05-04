<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/profil-PPID', function () {
    return view('profil-PPID');
});

Route::get('/tugas-dan-fungsi', function () {
    return view('tugas-dan-fungsi');
});