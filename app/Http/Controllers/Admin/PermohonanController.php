<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\PermohonanFile;
use App\Models\PermohonanReplyFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusUpdateMail;
use App\Notifications\PermohonanStatusUpdated;
use App\Services\WablasService;
use Illuminate\Support\Arr;
use ZipArchive;


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
        $permohonan->load('user','files','replyFiles', 'keberatan');

        return view('admin.permohonan.show', compact('permohonan'));
    }

    //Update permohonan + keberatan + notif (status, petugas notes, reply file)
    public function update(Request $request, Permohonan $permohonan, WablasService $wablas)
    {
        $validated = $request->validate([
            // PERMOHONAN
            'status'             => 'required|string',
            'keterangan_petugas' => 'nullable|string',

            // Permohonan reply files
            'reply_files'   => 'nullable|array|max:10',
            'reply_files.*' => 'file|mimes:pdf,doc,docx|max:5120',

            'delete_reply_file_ids'   => 'nullable|array',
            'delete_reply_file_ids.*' => 'integer|exists:permohonan_reply_files,id',

            // KEBERATAN
            'keberatan_status'             => 'nullable|string|in:Pending,Diproses,Diterima,Ditolak',
            'keberatan_keterangan_petugas' => 'nullable|string',

            'keberatan_reply_files'   => 'nullable|array|max:10',
            'keberatan_reply_files.*' => 'file|mimes:pdf,doc,docx|max:5120',

            'delete_keberatan_reply_file_ids'   => 'nullable|array',
            'delete_keberatan_reply_file_ids.*' => 'integer|exists:keberatan_reply_files,id',

            // notification
            'notify_whatsapp' => 'nullable|boolean',
            'notify_email'    => 'nullable|boolean',
        ]);


        // PERMOHONAN: delete reply files
        $deleteReplyFileIds = $validated['delete_reply_file_ids'] ?? [];

        if (! empty($deleteReplyFileIds)) {
            $replyFilesToDelete = $permohonan->replyFiles()
                ->whereIn('id', $deleteReplyFileIds)
                ->get();

            foreach ($replyFilesToDelete as $file) {
                if (Storage::disk('local')->exists($file->path)) {
                    Storage::disk('local')->delete($file->path);
                }
                $file->delete();
            }
        }

        // PERMOHONAN: add new reply files
        $replyFiles = $request->file('reply_files', []);

        if (! empty($replyFiles)) {
            $existingCount = $permohonan->replyFiles()->count();
            $newCount      = count($replyFiles);
            $totalAfter    = $existingCount + $newCount;

            if ($totalAfter > 10) {
                return back()
                    ->withErrors([
                        'reply_files' => 'Jumlah file balasan tidak boleh lebih dari 10.',
                    ])
                    ->withInput();
            }

            foreach ($replyFiles as $uploadedFile) {
                $path = $uploadedFile->store('permohonan_reply', 'local');

                $permohonan->replyFiles()->create([
                    'path'          => $path,
                    'original_name' => $uploadedFile->getClientOriginalName(),
                    'size'          => $uploadedFile->getSize(),
                    'mime_type'     => $uploadedFile->getClientMimeType(),
                ]);
            }
        }

        // KEBERATAN: update + files (only if keberatan exists)
        $keberatan = $permohonan->keberatan;

        if ($keberatan) {
            // DELETE keberatan reply files
            $deleteKbReplyFileIds = $validated['delete_keberatan_reply_file_ids'] ?? [];

            if (! empty($deleteKbReplyFileIds)) {
                $kbFilesToDelete = $keberatan->replyFiles()
                    ->whereIn('id', $deleteKbReplyFileIds)
                    ->get();

                foreach ($kbFilesToDelete as $file) {
                    if (Storage::disk('local')->exists($file->path)) {
                        Storage::disk('local')->delete($file->path);
                    }
                    $file->delete();
                }
            }

            // ADD keberatan reply files
            $kbReplyFiles = $request->file('keberatan_reply_files', []);

            if (! empty($kbReplyFiles)) {
                $existingKbCount = $keberatan->replyFiles()->count();
                $newKbCount      = count($kbReplyFiles);
                $totalKbAfter    = $existingKbCount + $newKbCount;

                if ($totalKbAfter > 10) {
                    return back()
                        ->withErrors([
                            'keberatan_reply_files' => 'Jumlah file balasan keberatan tidak boleh lebih dari 10.',
                        ])
                        ->withInput();
                }

                foreach ($kbReplyFiles as $uploadedFile) {
                    $path = $uploadedFile->store('keberatan_reply', 'local');

                    $keberatan->replyFiles()->create([
                        'path'          => $path,
                        'original_name' => $uploadedFile->getClientOriginalName(),
                        'size'          => $uploadedFile->getSize(),
                        'mime_type'     => $uploadedFile->getClientMimeType(),
                    ]);
                }
            }

            // UPDATE keberatan status + keterangan_petugas
            $kbUpdateData = [];

            if (! empty($validated['keberatan_status'])) {
                $kbUpdateData['status'] = $validated['keberatan_status'];
            }

            if (array_key_exists('keberatan_keterangan_petugas', $validated)) {
                $kbUpdateData['keterangan_petugas'] = $validated['keberatan_keterangan_petugas'];
            }

            if (! empty($kbUpdateData)) {
                $keberatan->update($kbUpdateData);
            }
        }

        //PERMOHONAN: update fields
        $permohonan->update(
            Arr::only($validated, ['status', 'keterangan_petugas'])
        );

        // Notification
        $channels = array_values(array_filter([
            $request->boolean('notify_whatsapp') ? 'wablas' : null,
            $request->boolean('notify_email')    ? 'mail'   : null,
        ]));

        if (!empty($channels)) {
            $permohonan->user->notify(new PermohonanStatusUpdated($permohonan, $channels));
        }

        return redirect()
            ->route('admin.permohonan.show', $permohonan->id)
            ->with('success', 'Permohonan berhasil diperbarui.');
    }


    public function search(Request $request)
    {
        $keyword   = $request->input('q');
        $status    = $request->input('status');              // single
        $statuses  = (array) $request->input('statuses', []); // multi (preset)
        $type      = $request->input('permohonan_type');
        $keberatan = $request->input('has_keberatan');

        $query = Permohonan::with(['user', 'keberatan']);

        // Keyword search
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('keterangan_user', 'like', "%{$keyword}%")
                ->orWhere('keterangan_petugas', 'like', "%{$keyword}%")
                ->orWhereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('name', 'like', "%{$keyword}%")
                                ->orWhere('email', 'like', "%{$keyword}%");
                });
            });
        }

        // Status filter: DO NOT MIX single and multi
        // Priority: explicit single status > statuses[] preset
        if ($status && $status !== 'Semua') {
            $query->where('status', $status);
        } elseif (!empty($statuses)) {
            // Clean up empty values just in case
            $statuses = array_values(array_filter($statuses, fn ($s) => $s !== null && $s !== ''));
            if (!empty($statuses)) {
                $query->whereIn('status', $statuses);
            }
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by permohonan_type
        if ($type && $type !== 'Semua') {
            $query->where('permohonan_type', $type);
        }

        // Filter by keberatan exist
        if ($keberatan === 'ya') {
            $query->whereHas('keberatan');
        } elseif ($keberatan === 'tidak') {
            $query->whereDoesntHave('keberatan');
        }

        $permohonans = $query->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.permohonan.search', compact('permohonans', 'keyword'));
    }



    public function downloadFile(Permohonan $permohonan, PermohonanFile $file)
    {
        if ($file->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404);
        }

        $absolutePath = Storage::disk('local')->path($file->path);

        return response()->download($absolutePath, $file->original_name);
    }


    public function downloadAllFilesZip(Permohonan $permohonan)
    {
        $files = $permohonan->files;

        if ($files->isEmpty()) {
            return back()->with('error', 'Tidak ada lampiran untuk diunduh.');
        }

        $zipFileName = 'permohonan-' . $permohonan->id . '-lampiran.zip';
        $tempDir     = storage_path('app/temp');
        $tempPath    = $tempDir . '/' . $zipFileName;

        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($tempPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        foreach ($files as $file) {
            if (Storage::disk('local')->exists($file->path)) {
                $absolutePath = Storage::disk('local')->path($file->path);
                // Use original_name inside the zip
                $zip->addFile($absolutePath, $file->original_name);
            }
        }

        $zip->close();

        return response()->download($tempPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function viewFile(Permohonan $permohonan, PermohonanFile $file)
    {
        if ($file->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404);
        }

        // (failsafe) if not PDF, just send them to the download route
        if (! $file->isPdf()) {
            return redirect()->route('admin.permohonan.files.download', [$permohonan->id, $file->id]);
        }

        $absolutePath = Storage::disk('local')->path($file->path);

        // stream inline so browser opens PDF viewer
        return response()->file($absolutePath, [
            'Content-Disposition' => 'inline; filename="' . $file->original_name . '"',
        ]);
    }

    public function downloadReplyFile(Permohonan $permohonan, PermohonanReplyFile $file)
    {
        if ($file->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404);
        }

        $absolutePath = Storage::disk('local')->path($file->path);

        return response()->download($absolutePath, $file->original_name);
    }

    public function viewReplyFile(Permohonan $permohonan, PermohonanReplyFile $file)
    {
        if ($file->permohonan_id !== $permohonan->id) {
            abort(404);
        }

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404);
        }

        // (failsafe) if not PDF, just send them to the download route
        if (! $file->isPdf()) {
            return redirect()->route('admin.permohonan.reply-files.download', [$permohonan->id, $file->id]);
        }

        $absolutePath = Storage::disk('local')->path($file->path);

        // stream inline so browser opens PDF viewer
        return response()->file($absolutePath, [
            'Content-Disposition' => 'inline; filename="' . $file->original_name . '"',
        ]);
    }

}
