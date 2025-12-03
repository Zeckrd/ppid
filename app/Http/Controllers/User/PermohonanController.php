<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\PermohonanFile;
use Illuminate\Support\Facades\Storage;
use App\Services\WhatsAppNotificationService;

class PermohonanController extends Controller
{
    public function create()
    {
        return view('user.dashboard.permohonan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'permohonan_type' => 'required|in:biasa,khusus',
            'keterangan_user' => 'required|string|max:512',
            'reply_type'      => 'required|in:softcopy,hardcopy',

            'permohonan_files'   => 'required|array|min:1|max:10',
            'permohonan_files.*' => 'file|mimes:pdf,doc,docx|max:2048',
        ]);

        // create permohonan
        $permohonan = Permohonan::create([
            'user_id'         => auth()->id(),
            'permohonan_type' => $validated['permohonan_type'],
            'keterangan_user' => $validated['keterangan_user'],
            'reply_type'      => $validated['reply_type'],
        ]);

        // store each file on private disk and create records
        /** @var \Illuminate\Http\UploadedFile[] $uploadedFiles */
        $uploadedFiles = $request->file('permohonan_files', []);

        foreach ($uploadedFiles as $uploadedFile) {
            // store in private area: storage/app/permohonan/...
            $path = $uploadedFile->store('permohonan', 'local'); 

            $permohonan->files()->create([
                'path'          => $path,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'size'          => $uploadedFile->getSize(),
                'mime_type'     => $uploadedFile->getClientMimeType(),
            ]);
        }

        // WhatsApp notification on permohonan created
        app(WhatsAppNotificationService::class)
            ->notifyPermohonanCreated($permohonan);

        return redirect()
            ->route('user.dashboard.index')
            ->with('success', 'Permohonan berhasil dibuat.');
    }


    public function show(Permohonan $permohonan)
    {
        $permohonan->load('files', 'keberatan');
        return view('user.dashboard.permohonan.show', compact('permohonan'));
    }

    public function edit(Permohonan $permohonan)
    {
        return view('user.dashboard.permohonan.edit', compact('permohonan'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        // status 'Menunggu Verifikasi Berkas Dari Petugas', 'Perlu Diperbaiki' can be edited
        $canEditFiles = in_array(
            $permohonan->status,
            ['Menunggu Verifikasi Berkas Dari Petugas', 'Perlu Diperbaiki']
        );

        $rules = [
            'permohonan_type' => 'required|in:biasa,khusus',
            'keterangan_user' => 'required|string',
            'reply_type'      => 'required|in:softcopy,hardcopy',
        ];

        if ($canEditFiles) {
            $rules['permohonan_files']   = 'nullable|array|max:10';
            $rules['permohonan_files.*'] = 'file|mimes:pdf,doc,docx|max:2048';

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
            // Delete selected existing files
            $deleteIds = $validated['delete_file_ids'] ?? [];

            if (! empty($deleteIds)) {
                $filesToDelete = $permohonan->files()
                    ->whereIn('id', $deleteIds)
                    ->get();

                foreach ($filesToDelete as $file) {
                    // delete physical file
                    if (Storage::disk('local')->exists($file->path)) {
                        Storage::disk('local')->delete($file->path);
                    }

                    // delete DB record
                    $file->delete();
                }
            }

            // Add new files
            $newFiles = $request->file('permohonan_files', []);

            $currentCount  = $permohonan->files()->count();
            $newFilesCount = $newFiles ? count($newFiles) : 0;
            $totalAfter    = $currentCount + $newFilesCount;

            if ($totalAfter > 10) {
                return back()
                    ->withErrors([
                        'permohonan_files' => 'Jumlah lampiran tidak boleh lebih dari 10.',
                    ])
                    ->withInput();
            }

            if (! empty($newFiles)) {
                foreach ($newFiles as $uploadedFile) {
                    $path = $uploadedFile->store('permohonan', 'local');

                    $permohonan->files()->create([
                        'path'          => $path,
                        'original_name' => $uploadedFile->getClientOriginalName(),
                        'size'          => $uploadedFile->getSize(),
                        'mime_type'     => $uploadedFile->getClientMimeType(),
                    ]);
                }
            }

            // ensure at least 1 attachment remains
            if ($permohonan->files()->count() === 0) {
                return back()
                    ->withErrors([
                        'permohonan_files' => 'Minimal satu lampiran diperlukan.',
                    ])
                    ->withInput();
            }
        }

        // Status reset logic
        if ($permohonan->status === 'Perlu Diperbaiki') {
            $updateData['status'] = 'Menunggu Verifikasi Berkas Dari Petugas';
            $updateData['keterangan_petugas'] = null;
        }

        $permohonan->update($updateData);

        // WhatsApp notification on permohonan updated by user
        app(WhatsAppNotificationService::class)
            ->notifyPermohonanUpdatedByUser($permohonan);

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Permohonan berhasil diperbarui.');
    }

    public function downloadFile(Permohonan $permohonan, PermohonanFile $file)
    {
        // Ensure file belongs to this permohonan
        if ($file->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        // Ensure current user owns this permohonan
        if ($permohonan->user_id !== auth()->id()) {
            abort(403);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404);
        }

        $absolutePath = Storage::disk('local')->path($file->path);

        return response()->download($absolutePath, $file->original_name);
    }

}
