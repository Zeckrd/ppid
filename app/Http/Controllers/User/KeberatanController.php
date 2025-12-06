<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Models\Permohonan;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
            'keberatan_file'  => 'nullable|file|mimes:pdf,doc,docx|max:5120',
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

    public function downloadReplyFile(Permohonan $permohonan, Keberatan $keberatan)
    {
        // Make sure this keberatan belongs to this permohonan
        if ($keberatan->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        // Make sure this permohonan belongs to logged-in user
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        if (! $keberatan->reply_file || ! Storage::disk('local')->exists($keberatan->reply_file)) {
            abort(404, 'File balasan keberatan tidak ditemukan.');
        }

        $absolutePath = Storage::disk('local')->path($keberatan->reply_file);

        $extension    = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $downloadName = 'balasan-keberatan-' . $keberatan->id . '.' . $extension;

        return response()->download($absolutePath, $downloadName);
    }
}
