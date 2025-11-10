<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keberatan;
use Illuminate\Support\Facades\Storage;

class KeberatanController extends Controller
{
    public function update(Request $request, $id)
    {

        $keberatan = Keberatan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Pending,Diproses,Selesai',
            'keterangan_petugas' => 'nullable|string|max:1000',
            'keberatan_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);


        if ($request->hasFile('keberatan_file')) {
            // Delete old file
            if ($keberatan->reply_file && Storage::exists($keberatan->reply_file)) {
                Storage::delete($keberatan->reply_file);
            }


            $path = $request->file('keberatan_file')->store('public/keberatan');
            $validated['reply_file'] = $path;
        }


        $keberatan->update([
            'status' => $validated['status'],
            'keterangan_petugas' => $validated['keterangan_petugas'] ?? $keberatan->keterangan_petugas,
            'reply_file' => $validated['reply_file'] ?? $keberatan->reply_file,
        ]);


        return back()->with('success', 'Keberatan berhasil diperbarui.');
    }
}
