<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Keberatan;
use App\Models\Permohonan;
use App\Models\KeberatanFile;
use App\Models\KeberatanReplyFile;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminKeberatanCreated;

class KeberatanController extends Controller
{
    public function create(Permohonan $permohonan)
    {
        $status = strtolower(trim($permohonan->status));

        $allowedStatuses = [
            'perlu diperbaiki',
            'menunggu verifikasi berkas dari petugas',
            'diterima',
            'ditolak',
        ];

        if (! in_array($status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Permohonan ini tidak dapat diajukan keberatan.');
        }

        if ($permohonan->keberatan) {
            return redirect()
                ->route('user.permohonan.show', $permohonan)
                ->with('error', 'Keberatan sudah diajukan.');
        }

        return view('user.dashboard.keberatan.create', compact('permohonan'));
    }

    public function store(Request $request, Permohonan $permohonan)
    {
        $validated = $request->validate([
            'keterangan_user'   => 'required|string|max:1000',
            'keberatan_files'   => 'required|array|min:1|max:10',
            'keberatan_files.*' => 'file|mimes:pdf,doc,docx|max:5120',
        ]);

        // create keberatan (without file columns)
        $keberatan = Keberatan::create([
            'permohonan_id'   => $permohonan->id,
            'keterangan_user' => $validated['keterangan_user'],
        ]);

        /** @var \Illuminate\Http\UploadedFile[] $uploadedFiles */
        $uploadedFiles = $request->file('keberatan_files', []);

        foreach ($uploadedFiles as $uploadedFile) {
            $path = $uploadedFile->store('private/keberatan', 'local');

            $keberatan->files()->create([
                'path'          => $path,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'size'          => $uploadedFile->getSize(),
                'mime_type'     => $uploadedFile->getClientMimeType(),
            ]);
        }

        // update permohonan status
        $permohonan->update([
            'status' => 'Menunggu Verifikasi Berkas Dari Petugas',
        ]);

        // WhatsApp notification on keberatan created
        $admins = User::admins()->get();
        Notification::send($admins, new AdminKeberatanCreated($keberatan));

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Keberatan berhasil diajukan dan status permohonan diperbarui.');
    }

    public function downloadFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanFile $file)
    {
        // ownership n relation check
        if ($permohonan->id !== $keberatan->permohonan_id) {
            abort(404);
        }

        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($file->keberatan_id !== $keberatan->id) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404, 'File keberatan tidak ditemukan.');
        }

        $absolutePath = Storage::disk('local')->path($file->path);
        $extension    = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $downloadName = $file->original_name ?? ('keberatan-' . $file->id . '.' . $extension);

        return response()->download($absolutePath, $downloadName);
    }

    public function downloadReplyFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanReplyFile $file
    ) {
        if ($permohonan->id !== $keberatan->permohonan_id) {
            abort(404);
        }

        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($file->keberatan_id !== $keberatan->id) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404, 'File balasan keberatan tidak ditemukan.');
        }

        $absolutePath = Storage::disk('local')->path($file->path);
        $extension    = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $downloadName = $file->original_name ?? ('balasan-keberatan-' . $file->id . '.' . $extension);

        return response()->download($absolutePath, $downloadName);
    }

        public function viewFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanFile $file)
    {
        // relation n ownership check
        if ($keberatan->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($file->keberatan_id !== $keberatan->id) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404, 'File keberatan tidak ditemukan.');
        }

        $absolutePath = Storage::disk('local')->path($file->path);

        return response()->file($absolutePath);
    }

    public function viewReplyFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanReplyFile $file)
    {
        if ($keberatan->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        if ($file->keberatan_id !== $keberatan->id) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404, 'File balasan keberatan tidak ditemukan.');
        }

        $absolutePath = Storage::disk('local')->path($file->path);

        return response()->file($absolutePath);
    }
}