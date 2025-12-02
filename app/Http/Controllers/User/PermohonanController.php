<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;
use App\Services\WhatsAppNotificationService;

class PermohonanController extends Controller
{
    public function create()
    {
        return view('user.dashboard.permohonan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'permohonan_type' => 'required|in:biasa,khusus',
            'permohonan_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'keterangan_user' => 'required|string|max:512',
            'reply_type'      => 'required|in:softcopy,hardcopy',
        ]);

        $path = $request->file('permohonan_file')->store('permohonan', 'public');

        // keep the created model instance to notify
        $permohonan = Permohonan::create([
            'user_id'         => auth()->id(),
            'permohonan_type' => $request->permohonan_type,
            'permohonan_file' => $path,
            'keterangan_user' => $request->keterangan_user,
            'reply_type'      => $request->reply_type,
        ]);

        // WhatsApp notification on permohonan created
        app(WhatsAppNotificationService::class)
            ->notifyPermohonanCreated($permohonan);

        return redirect()->route('user.dashboard.index')
                         ->with('success', 'Permohonan berhasil dibuat.');
    }

    public function show(Permohonan $permohonan)
    {
        return view('user.dashboard.permohonan.show', compact('permohonan'));
    }

    public function edit(Permohonan $permohonan)
    {
        return view('user.dashboard.permohonan.edit', compact('permohonan'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'permohonan_type' => 'required|in:biasa,khusus',
            'keterangan_user' => 'required|string',
            'reply_type'      => 'required|in:softcopy,hardcopy',
            'permohonan_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $updateData = $request->only(['permohonan_type', 'keterangan_user', 'reply_type']);

        if ($request->hasFile('permohonan_file')) {
            if ($permohonan->permohonan_file && Storage::disk('public')->exists($permohonan->permohonan_file)) {
                Storage::disk('public')->delete($permohonan->permohonan_file);
            }
            $updateData['permohonan_file'] = $request->file('permohonan_file')->store('permohonan', 'public');
        }

        if ($permohonan->status == 'Perlu Diperbaiki') {
            $updateData['status'] = 'Menunggu Verifikasi Berkas Dari Petugas';
            $updateData['keterangan_petugas'] = null;
        }

        $permohonan->update($updateData);

        // WhatsApp notification on permohonan updated by user
        app(WhatsAppNotificationService::class)
            ->notifyPermohonanUpdatedByUser($permohonan);

        return redirect()->route('user.permohonan.show', $permohonan)
                         ->with('success', 'Permohonan berhasil diperbarui.');
    }
}
