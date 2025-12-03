<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keberatan;
use Illuminate\Support\Facades\Storage;

class KeberatanController extends Controller
{
    public function update(Request $request, Keberatan $keberatan)
    {
        $validated = $request->validate([
            'status'             => 'required|in:Pending,Diproses,Diterima,Ditolak',
            'keterangan_petugas' => 'nullable|string|max:1000',
            // ADMIN reply file
            'keberatan_file'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle reply file upload
        if ($request->hasFile('keberatan_file')) {
            // Delete old file (from local disk)
            if ($keberatan->reply_file && Storage::disk('local')->exists($keberatan->reply_file)) {
                Storage::disk('local')->delete($keberatan->reply_file);
            }

            // Store new reply file on the local disk (private)
            // will return something like "keberatan/replies/xxxxx.pdf"
            $path = $request->file('keberatan_file')->store('keberatan/replies', 'local');

            $keberatan->reply_file = $path;
        }

        $keberatan->status = $validated['status'];
        $keberatan->keterangan_petugas = $validated['keterangan_petugas'] ?? $keberatan->keterangan_petugas;
        $keberatan->save();

        return back()->with('success', 'Keberatan berhasil diperbarui.');
    }

    public function downloadReplyFile(\App\Models\Permohonan $permohonan, Keberatan $keberatan)
    {
        if ($keberatan->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        if (! $keberatan->reply_file || ! Storage::disk('local')->exists($keberatan->reply_file)) {
            abort(404, 'File balasan keberatan tidak ditemukan.');
        }

        $absolutePath = Storage::disk('local')->path($keberatan->reply_file);

        // filename for download
        $extension    = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $downloadName = 'balasan-keberatan-' . $keberatan->id . '.' . $extension;

        return response()->download($absolutePath, $downloadName);
    }
}
