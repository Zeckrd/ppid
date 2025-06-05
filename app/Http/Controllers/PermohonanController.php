<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index()
{
    dd(auth()->user());
    $permohonans = \App\Models\Permohonan::with('user')->latest()->simplePaginate(10);

    return view('dashboard.index', [
        'permohonans' => $permohonans
    ]);
}

}
