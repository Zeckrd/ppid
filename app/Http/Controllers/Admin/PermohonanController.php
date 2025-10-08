<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $query = Permohonan::query();

        // Apply filter if "status" is provided
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $permohonans = $query->latest()->paginate(10);

        return view('admin.permohonan.index', compact('permohonans'));
    }

    public function show(Permohonan $permohonan)
    {
        $permohonan->load('user', 'keberatan');

        return view('admin.permohonan.show', compact('permohonan'));
    }

    /**
     * Update permohonan (status, petugas notes, reply file).
     */
    public function update(Request $request, Permohonan $permohonan)
    {
        $validated = $request->validate([
            'status'             => 'required|string',
            'keterangan_petugas' => 'nullable|string|max:1000',
            'reply_file'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('reply_file')) {
            // Delete old reply file if exists
            if ($permohonan->reply_file && Storage::disk('public')->exists($permohonan->reply_file)) {
                Storage::disk('public')->delete($permohonan->reply_file);
            }

            $validated['reply_file'] = $request->file('reply_file')->store('reply_files', 'public');
        }

        $permohonan->update($validated);

        return redirect()
            ->route('admin.permohonan.show', $permohonan->id)
            ->with('success', 'Permohonan berhasil diperbarui.');
    }
}
