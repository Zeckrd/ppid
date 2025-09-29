<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeberatanController extends Controller
{
    public function create(Permohonan $permohonan)
    {
        // Only allow if status is Perlu Diperbaiki or Selesai
        if (!in_array($permohonan->status, ['Perlu Diperbaiki', 'Selesai'])) {
            return redirect()->back()->with('error', 'Permohonan ini tidak dapat diajukan keberatan.');
        }

        // Prevent duplicate
        if ($permohonan->keberatan) {
            return redirect()->route('user.permohonan.show', $permohonan)->with('error', 'Keberatan sudah diajukan.');
        }

        return view('user.keberatan.create', compact('permohonan'));
    }

    public function store(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'keterangan_user' => 'required|string|max:1000',
            'keberatan_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;

        if ($request->hasFile('keberatan_file')) {
            $filePath = $request->file('keberatan_file')->store('keberatan', 'public');
        }

        Keberatan::create([
            'permohonan_id' => $permohonan->id,
            'keterangan_user' => $request->keterangan_user,
            'keberatan_file' => $filePath,
        ]);

        return redirect()->route('user.permohonan.show', $permohonan)->with('success', 'Keberatan berhasil diajukan.');
    }

    public function show(Keberatan $keberatan)
    {
        return view('user.keberatan.show', compact('keberatan'));
    }
}
