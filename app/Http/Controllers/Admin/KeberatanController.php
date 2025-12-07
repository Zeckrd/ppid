<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Keberatan;
use App\Models\KeberatanFile;
use App\Models\KeberatanReplyFile;
use Illuminate\Support\Facades\Storage;

class KeberatanController extends Controller
{
    public function update(Request $request, Keberatan $keberatan)
    {
        $validated = $request->validate([
            'status'             => 'required|in:Pending,Diproses,Diterima,Ditolak',
            'keterangan_petugas' => 'nullable|string|max:1000',

            'keberatan_reply_files'   => 'nullable|array|max:10',
            'keberatan_reply_files.*' => 'file|mimes:pdf,doc,docx|max:5120',

            'delete_keberatan_reply_file_ids'   => 'nullable|array',
            'delete_keberatan_reply_file_ids.*' => 'integer|exists:keberatan_reply_files,id',
        ]);

        // handle new reply files
        /** @var \Illuminate\Http\UploadedFile[] $uploadedReplyFiles */
        $uploadedReplyFiles = $request->file('keberatan_reply_files', []);

        foreach ($uploadedReplyFiles as $uploadedFile) {
            $path = $uploadedFile->store('private/keberatan_reply', 'local');

            $keberatan->replyFiles()->create([
                'path'          => $path,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'size'          => $uploadedFile->getSize(),
                'mime_type'     => $uploadedFile->getClientMimeType(),
            ]);
        }

        // handle delete selected reply files
        $deleteIds = $validated['delete_keberatan_reply_file_ids'] ?? [];
        if (! empty($deleteIds)) {
            $filesToDelete = KeberatanReplyFile::whereIn('id', $deleteIds)
                ->where('keberatan_id', $keberatan->id)
                ->get();

            foreach ($filesToDelete as $file) {
                if (Storage::disk('local')->exists($file->path)) {
                    Storage::disk('local')->delete($file->path);
                }
                $file->delete();
            }
        }

        $keberatan->status = $validated['status'];
        $keberatan->keterangan_petugas = $validated['keterangan_petugas'] ?? $keberatan->keterangan_petugas;
        $keberatan->save();

        return back()->with('success', 'Keberatan berhasil diperbarui.');
    }

    public function downloadFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanFile $file)
    {
        if ($keberatan->permohonan_id !== $permohonan->id) {
            abort(404);
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
        if ($keberatan->permohonan_id !== $permohonan->id) {
            abort(404);
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
        if ($keberatan->permohonan_id !== $permohonan->id) {
            abort(404);
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

    public function viewReplyFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanReplyFile $file
    ) {
        if ($keberatan->permohonan_id !== $permohonan->id) {
            abort(404);
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
