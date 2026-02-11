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

    protected function isPdfLike($file): bool
    {
        $mime = strtolower((string) ($file->mime_type ?? ''));
        if ($mime === 'application/pdf') return true;

        $name = strtolower((string) ($file->original_name ?? ''));
        return str_ends_with($name, '.pdf');
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

        $permohonan->update([
            'status' => 'Menunggu Verifikasi',
        ]);

        $admins = User::admins()->get();
        Notification::send($admins, new AdminKeberatanCreated($keberatan));

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Keberatan berhasil diajukan dan status permohonan diperbarui.');
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

        // Only inline PDF; others download
        if (! $this->isPdfLike($file)) {
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

        // Only inline PDF; others download
        if (! $this->isPdfLike($file)) {
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
