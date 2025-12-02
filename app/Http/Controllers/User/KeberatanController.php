<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Models\Permohonan;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;

class KeberatanController extends Controller
{
    public function create(Permohonan $permohonan)
    {
        $status = strtolower(trim($permohonan->status));

        $allowedStatuses = [
            'perlu diperbaiki',
            'menunggu verifikasi berkas dari petugas',
            'diterima',
            'ditolak'
        ];

        if (!in_array($status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Permohonan ini tidak dapat diajukan keberatan.');
        }

        if ($permohonan->keberatan) {
            return redirect()->route('user.permohonan.show', $permohonan)
                             ->with('error', 'Keberatan sudah diajukan.');
        }

        return view('user.dashboard.keberatan.create', compact('permohonan'));
    }

    public function store(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'keterangan_user' => 'required|string|max:1000',
            'keberatan_file'  => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;

        if ($request->hasFile('keberatan_file')) {
            $filePath = $request->file('keberatan_file')->store('keberatan', 'public');
        }

        $keberatan = Keberatan::create([
            'permohonan_id'   => $permohonan->id,
            'keterangan_user' => $request->keterangan_user,
            'keberatan_file'  => $filePath,
        ]);

        $permohonan->update([
            'status' => 'Menunggu Verifikasi Berkas Dari Petugas',
        ]);

        // WhatsApp notification on keberatan created
        app(WhatsAppNotificationService::class)
            ->notifyKeberatanCreated($keberatan);

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Keberatan berhasil diajukan dan status permohonan diperbarui.');
    }

    public function show(Keberatan $keberatan)
    {
        return view('user.dashboard.keberatan.show', compact('keberatan'));
    }
}
