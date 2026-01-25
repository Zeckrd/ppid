<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\PermohonanFile;
use App\Models\PermohonanReplyFile;
use App\Notifications\AdminPermohonanCreated;
use App\Notifications\AdminPermohonanUpdatedByUser;

class PermohonanController extends Controller
{
    /**
     * Make a filename to store/display/download.
     */
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

    public function create()
    {
        return view('user.dashboard.permohonan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'permohonan_type' => 'required|in:biasa,khusus',
            'keterangan_user' => 'required|string|max:1024',
            'reply_type'      => 'required|in:softcopy,hardcopy',

            'permohonan_files'   => 'required|array|min:1|max:10',
            'permohonan_files.*' => 'file|mimes:pdf,doc,docx|max:5120',
        ]);

        $permohonan = Permohonan::create([
            'user_id'         => auth()->id(),
            'permohonan_type' => $validated['permohonan_type'],
            'keterangan_user' => $validated['keterangan_user'],
            'reply_type'      => $validated['reply_type'],
        ]);

        $uploadedFiles = $request->file('permohonan_files', []);

        foreach ($uploadedFiles as $uploadedFile) {
            $path = $uploadedFile->store('permohonan', 'local');

            $safeName = $this->sanitizeFilename($uploadedFile->getClientOriginalName());

            $permohonan->files()->create([
                'path'          => $path,
                'original_name' => $safeName,
                'size'          => $uploadedFile->getSize(),
                'mime_type'     => $uploadedFile->getMimeType(),
            ]);
        }

        $admins = User::admins()->get();
        Notification::send($admins, new AdminPermohonanCreated($permohonan));

        return redirect()
            ->route('user.dashboard.index')
            ->with('success', 'Permohonan berhasil dibuat.');
    }

    public function show(Permohonan $permohonan)
    {
        $this->authorize('view', $permohonan);

        $permohonan->load(['buktiBayar', 'files', 'replyFiles', 'keberatan.files', 'keberatan.replyFiles']);
        return view('user.dashboard.permohonan.show', compact('permohonan'));
    }

    public function edit(Permohonan $permohonan)
    {
        $this->authorize('update', $permohonan);

        return view('user.dashboard.permohonan.edit', compact('permohonan'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $this->authorize('update', $permohonan);

        $canEditFiles = in_array(
            $permohonan->status,
            ['Menunggu Verifikasi Berkas Dari Petugas', 'Perlu Diperbaiki']
        );

        $rules = [
            'permohonan_type' => 'required|in:biasa,khusus',
            'keterangan_user' => 'required|string|max:1024',
            'reply_type'      => 'required|in:softcopy,hardcopy',
        ];

        if ($canEditFiles) {
            $rules['permohonan_files']   = 'nullable|array|max:10';
            $rules['permohonan_files.*'] = 'file|mimes:pdf,doc,docx|max:5120';

            $rules['delete_file_ids']   = 'nullable|array';
            $rules['delete_file_ids.*'] = 'integer|exists:permohonan_files,id';
        }

        $validated = $request->validate($rules);

        $updateData = [
            'permohonan_type' => $validated['permohonan_type'],
            'keterangan_user' => $validated['keterangan_user'],
            'reply_type'      => $validated['reply_type'],
        ];

        if ($canEditFiles) {
            $deleteIds = $validated['delete_file_ids'] ?? [];

            if (! empty($deleteIds)) {
                $filesToDelete = $permohonan->files()
                    ->whereIn('id', $deleteIds)
                    ->get();

                foreach ($filesToDelete as $file) {
                    if (Storage::disk('local')->exists($file->path)) {
                        Storage::disk('local')->delete($file->path);
                    }
                    $file->delete();
                }
            }

            $newFiles = $request->file('permohonan_files', []);

            $currentCount  = $permohonan->files()->count();
            $newFilesCount = $newFiles ? count($newFiles) : 0;

            if (($currentCount + $newFilesCount) > 10) {
                return back()
                    ->withErrors(['permohonan_files' => 'Jumlah lampiran tidak boleh lebih dari 10.'])
                    ->withInput();
            }

            foreach ($newFiles as $uploadedFile) {
                $path = $uploadedFile->store('permohonan', 'local');

                $safeName = $this->sanitizeFilename($uploadedFile->getClientOriginalName());

                $permohonan->files()->create([
                    'path'          => $path,
                    'original_name' => $safeName,
                    'size'          => $uploadedFile->getSize(),
                    'mime_type'     => $uploadedFile->getMimeType(),
                ]);
            }

            if ($permohonan->files()->count() === 0) {
                return back()
                    ->withErrors(['permohonan_files' => 'Minimal satu lampiran diperlukan.'])
                    ->withInput();
            }
        }

        if ($permohonan->status === 'Perlu Diperbaiki') {
            $updateData['status'] = 'Menunggu Verifikasi Berkas Dari Petugas';
            $updateData['keterangan_petugas'] = null;
        }

        $permohonan->update($updateData);

        $admins = User::admins()->get();
        Notification::send($admins, new AdminPermohonanUpdatedByUser($permohonan));

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Permohonan berhasil diperbarui.');
    }

    public function viewFile(Permohonan $permohonan, PermohonanFile $file)
    {
        $this->authorize('view', $permohonan);

        if ($file->permohonan_id !== $permohonan->id) abort(404);
        if (!Storage::disk('local')->exists($file->path)) abort(404);

        // Only inline PDF; others download
        if (! $file->isPdf()) {
            return redirect()->route('user.permohonan.files.download', [$permohonan->id, $file->id]);
        }

        $absolutePath = Storage::disk('local')->path($file->path);
        $safeName = $this->sanitizeFilename($file->original_name ?? 'file.pdf');

        return response()->file($absolutePath, [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline; filename="' . $safeName . '"',
        ]);
    }

    public function viewReplyFile(Permohonan $permohonan, PermohonanReplyFile $file)
    {
        $this->authorize('view', $permohonan);

        // ensure reply file belongs to this permohonan
        if ($file->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        if (!Storage::disk('local')->exists($file->path)) {
            abort(404);
        }

        // Only inline PDF; others go to download
        if (! $file->isPdf()) {
            return redirect()->route('user.permohonan.reply-files.download', [$permohonan->id, $file->id]);
        }

        $absolutePath = Storage::disk('local')->path($file->path);

        $filename = method_exists($this, 'sanitizeFilename')
            ? $this->sanitizeFilename($file->original_name ?? 'reply.pdf')
            : ($file->original_name ?? 'reply.pdf');

        return response()->file($absolutePath, [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }


    public function downloadFile(Permohonan $permohonan, PermohonanFile $file)
    {
        $this->authorize('view', $permohonan);

        if ($file->permohonan_id !== $permohonan->id) abort(404);
        if (!Storage::disk('local')->exists($file->path)) abort(404);

        $absolutePath = Storage::disk('local')->path($file->path);
        $safeName = $this->sanitizeFilename($file->original_name ?? 'file');

        return response()->download($absolutePath, $safeName);
    }

    public function downloadReplyFile(Permohonan $permohonan, PermohonanReplyFile $file)
    {
        $this->authorize('view', $permohonan);

        if ($file->permohonan_id !== $permohonan->id) abort(404);
        if (!Storage::disk('local')->exists($file->path)) abort(404);

        $absolutePath = Storage::disk('local')->path($file->path);
        $safeName = $this->sanitizeFilename($file->original_name ?? 'file');

        return response()->download($absolutePath, $safeName);
    }
}
