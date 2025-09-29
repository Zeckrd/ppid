<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = 
        [
            'menunggu_verifikasi' => Permohonan::where('status', 'Menunggu Verifikasi Berkas Dari Petugas')->count(),
            'diverifikasi'        => Permohonan::where('status', 'Sedang Diverifikasi petugas')->count(),
            'perlu_diperbaiki'            => Permohonan::where('status', 'Perlu Diperbaiki')->count(),
            'diproses'             => Permohonan::where('status', 'Permohonan Sedang Diproses')->count(),
            'selesai'    => Permohonan::where('status', 'Selesai')->count(),
        ];

        $statuses = 
        [
            'Menunggu Verifikasi Berkas Dari Petugas',
            'Sedang Diverifikasi petugas',
            'Perlu Diperbaiki',
            'Permohonan Sedang Diproses',
            'Selesai'
        ];


        return view('admin.dashboard', [
            'stats' => $stats,
            'statuses' => $statuses,
        ]);

    }
}
