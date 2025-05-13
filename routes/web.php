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