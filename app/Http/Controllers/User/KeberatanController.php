<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Keberatan;
use App\Models\Permohonan;
use App\Models\KeberatanFile;
use App\Models\KeberatanReplyFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminKeberatanCreated;

class KeberatanController extends Controller
{
    protected function sanitizeFilename(string $name): string
    {
        $name = preg_replace("/[\r\n]+/", ' ', $name);
        $name = trim($name);

        $ext  = pathinfo($name, PATHINFO_EXTENSION);
        $base = pathinfo($name, PATHINFO_FILENAME);

        $base = preg_replace('/[^\pL\pN .,_-]+/u', '-', $base);
        $base = preg_replace('/\s+/', ' ', $base);
        $base = trim($base, ".-_ ");

        if ($base === '') $base = 'file';

        $ext = preg_replace('/[^A-Za-z0-9]+/', '', $ext);
        $ext = strtolower($ext);

        return $ext ? ($base . '.' . $ext) : $base;
    }

    public function create(Permohonan $permohonan)
    {
        $this->authorize('view', $permohonan);

        $status = strtolower(trim($permohonan->status));

        $allowedStatuses = [
            'perlu diperbaiki',
            'diterima',
            'ditolak',
        ];

        if (! in_array($status, $allowedStatuses, true)) {
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
        $this->authorize('view', $permohonan);

        if ($permohonan->keberatan) {
            return back()->with('error', 'Keberatan sudah diajukan.');
        }

        $status = strtolower(trim($permohonan->status));
        $allowedStatuses = [
            'perlu diperbaiki',
            'diterima',
            'ditolak',
        ];
        if (! in_array($status, $allowedStatuses, true)) {
            return back()->with('error', 'Permohonan ini tidak dapat diajukan keberatan.');
        }

        $validated = $request->validate([
            'keterangan_user'   => 'required|string|max:1024',
            'keberatan_files'   => 'required|array|min:1|max:10',
            'keberatan_files.*' => 'file|mimes:pdf,doc,docx|max:5120',
        ]);

        $keberatan = Keberatan::create([
            'permohonan_id'   => $permohonan->id,
            'keterangan_user' => $validated['keterangan_user'],
        ]);

        $uploadedFiles = $request->file('keberatan_files', []);

        foreach ($uploadedFiles as $uploadedFile) {
            $path = $uploadedFile->store('private/keberatan', 'local');

            $safeName = $this->sanitizeFilename($uploadedFile->getClientOriginalName());

            $keberatan->files()->create([
                'path'          => $path,
                'original_name' => $safeName,
                'size'          => $uploadedFile->getSize(),
                'mime_type'     => $uploadedFile->getMimeType(),
            ]);
        }

        $admins = User::admins()->get();
        Notification::send($admins, new AdminKeberatanCreated($keberatan));

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Keberatan berhasil diajukan dan status permohonan diperbarui.');
    }

    public function edit(Keberatan $keberatan)
    {
        $this->authorize('update', $keberatan);

        $permohonan = $keberatan->permohonan;

        return view('user.dashboard.keberatan.edit', compact('keberatan', 'permohonan'));
    }

    public function update(Request $request, Permohonan $permohonan, Keberatan $keberatan)
    {
        $this->authorize('update', $keberatan);

        $permohonan = $keberatan->permohonan;

        $canEditFiles = in_array(
            $permohonan->status,
            ['Menunggu Verifikasi', 'Diverifikasi', 'Perlu Diperbaiki']
        );

        $rules = [
            'keterangan_user' => 'required|string|max:1024',
        ];

        if ($canEditFiles) {
            $rules['keberatan_files']   = 'nullable|array|max:10';
            $rules['keberatan_files.*'] = 'file|mimes:pdf,doc,docx|max:5120';

            $rules['delete_file_ids']   = 'nullable|array';
            $rules['delete_file_ids.*'] = 'integer|exists:keberatan_files,id';
        }

        $validated = $request->validate($rules);

        $updateData = [
            'keterangan_user' => $validated['keterangan_user'],
        ];

        if ($canEditFiles) {
            $deleteIds = $validated['delete_file_ids'] ?? [];

            if (!empty($deleteIds)) {
                $filesToDelete = $keberatan->files()
                    ->whereIn('id', $deleteIds)
                    ->get();

                foreach ($filesToDelete as $file) {
                    if (Storage::disk('local')->exists($file->path)) {
                        Storage::disk('local')->delete($file->path);
                    }
                    $file->delete();
                }
            }

            $newFiles = $request->file('keberatan_files', []);

            $currentCount  = $keberatan->files()->count();
            $newFilesCount = $newFiles ? count($newFiles) : 0;

            if (($currentCount + $newFilesCount) > 10) {
                return back()
                    ->withErrors(['keberatan_files' => 'Jumlah lampiran tidak boleh lebih dari 10.'])
                    ->withInput();
            }

            foreach ($newFiles as $uploadedFile) {
                $path = $uploadedFile->store('private/keberatan', 'local');

                $safeName = $this->sanitizeFilename($uploadedFile->getClientOriginalName());

                $keberatan->files()->create([
                    'path'          => $path,
                    'original_name' => $safeName,
                    'size'          => $uploadedFile->getSize(),
                    'mime_type'     => $uploadedFile->getMimeType(),
                ]);
            }

            if ($keberatan->files()->count() === 0) {
                return back()
                    ->withErrors(['keberatan_files' => 'Minimal satu lampiran diperlukan.'])
                    ->withInput();
            }
        }

        if ($permohonan->status === 'Perlu Diperbaiki') {
            $permohonan->update([
                'status' => 'Menunggu Verifikasi',
                'keterangan_petugas' => null,
            ]);
        }

        $keberatan->update($updateData);

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Keberatan berhasil diperbarui.');
    }

    public function downloadFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanFile $file)
    {
        $this->authorize('view', $permohonan);

        if ($permohonan->id !== $keberatan->permohonan_id) abort(404);
        if ($file->keberatan_id !== $keberatan->id) abort(404);
        if (!Storage::disk('local')->exists($file->path)) abort(404, 'File keberatan tidak ditemukan.');

        $absolutePath = Storage::disk('local')->path($file->path);
        $safeName = $this->sanitizeFilename($file->original_name ?? ('keberatan-' . $file->id));

        return response()->download($absolutePath, $safeName);
    }

    public function downloadReplyFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanReplyFile $file)
    {
        $this->authorize('view', $permohonan);

        if ($permohonan->id !== $keberatan->permohonan_id) abort(404);
        if ($file->keberatan_id !== $keberatan->id) abort(404);
        if (!Storage::disk('local')->exists($file->path)) abort(404, 'File balasan keberatan tidak ditemukan.');

        $absolutePath = Storage::disk('local')->path($file->path);
        $safeName = $this->sanitizeFilename($file->original_name ?? ('balasan-keberatan-' . $file->id));

        return response()->download($absolutePath, $safeName);
    }

    public function viewFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanFile $file)
    {
        $this->authorize('view', $permohonan);

        if ($keberatan->permohonan_id !== $permohonan->id) abort(404);
        if ($file->keberatan_id !== $keberatan->id) abort(404);
        if (!Storage::disk('local')->exists($file->path)) abort(404, 'File keberatan tidak ditemukan.');

        // Only inline PDF, others download
        if (! $file->isPdf()) {
            return redirect()->route('user.keberatan.files.download', [
                $permohonan->id, $keberatan->id, $file->id
            ]);
        }

        $absolutePath = Storage::disk('local')->path($file->path);
        $safeName = $this->sanitizeFilename($file->original_name ?? 'file.pdf');

        return response()->file($absolutePath, [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline; filename="' . $safeName . '"',
        ]);
    }

    public function viewReplyFile(Permohonan $permohonan, Keberatan $keberatan, KeberatanReplyFile $file)
    {
        $this->authorize('view', $permohonan);

        if ($keberatan->permohonan_id !== $permohonan->id) abort(404);
        if ($file->keberatan_id !== $keberatan->id) abort(404);
        if (!Storage::disk('local')->exists($file->path)) abort(404, 'File balasan keberatan tidak ditemukan.');

        // Only inline PDF, others download
        if (! $file->isPdf()) {
            return redirect()->route('user.keberatan.reply_files.download', [
                $permohonan->id, $keberatan->id, $file->id
            ]);
        }

        $absolutePath = Storage::disk('local')->path($file->path);
        $safeName = $this->sanitizeFilename($file->original_name ?? 'file.pdf');

        return response()->file($absolutePath, [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline; filename="' . $safeName . '"',
        ]);
    }
}
