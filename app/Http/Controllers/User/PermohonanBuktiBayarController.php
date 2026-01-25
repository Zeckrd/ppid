<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\PermohonanBuktiBayar;
use App\Models\User;
use App\Notifications\AdminBuktiBayarUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PermohonanBuktiBayarController extends Controller
{
    private const ALLOWED_STATUSES = ['Menunggu Pembayaran', 'Perlu Diperbaiki'];
    private const NEXT_STATUS_AFTER_UPLOAD = 'Memverifikasi Pembayaran';

    public function store(Request $request, Permohonan $permohonan)
    {
        $this->authorize('update', $permohonan);

        if (!$this->isUploadAllowed($permohonan)) {
            return back()->with('error', 'Upload bukti pembayaran tidak tersedia pada status ini.');
        }

        $data = $this->validated($request);

        // Enforce 1:1
        $permohonan->loadMissing('buktiBayar');
        if ($permohonan->buktiBayar) {
            return back()->with('error', 'Bukti pembayaran sudah ada. Silakan gunakan fitur ganti bukti.');
        }

        $file = $data['bukti_bayar'];
        $storedPath = $this->storeFile($permohonan, $file);

        PermohonanBuktiBayar::create([
            'permohonan_id' => $permohonan->id,
            'uploaded_by'   => Auth::id(),
            'path'          => $storedPath,
            'original_name' => $file->getClientOriginalName(),
            'mime'          => $file->getMimeType(),
            'size'          => $file->getSize(),
        ]);

        // Status transition
        $permohonan->status = self::NEXT_STATUS_AFTER_UPLOAD;
        $permohonan->save();

        // Notify admins via Wablas
        $this->notifyAdmins($permohonan);

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi petugas.');
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $this->authorize('update', $permohonan);

        if (!$this->isUploadAllowed($permohonan)) {
            return back()->with('error', 'Upload bukti pembayaran tidak tersedia pada status ini.');
        }

        $data = $this->validated($request);

        $permohonan->loadMissing('buktiBayar');

        $bukti = $permohonan->buktiBayar;
        if (!$bukti) {
            return back()->with('error', 'Belum ada bukti pembayaran. Silakan unggah terlebih dahulu.');
        }

        $file = $data['bukti_bayar'];
        $storedPath = $this->storeFile($permohonan, $file);

        // Delete old file (no history)
        if ($bukti->path && Storage::disk('local')->exists($bukti->path)) {
            Storage::disk('local')->delete($bukti->path);
        }

        $bukti->update([
            'uploaded_by'   => Auth::id(),
            'path'          => $storedPath,
            'original_name' => $file->getClientOriginalName(),
            'mime'          => $file->getMimeType(),
            'size'          => $file->getSize(),
        ]);

        // Status transition
        $permohonan->status = self::NEXT_STATUS_AFTER_UPLOAD;
        $permohonan->save();

        // Notify admins via Wablas
        $this->notifyAdmins($permohonan);

        return redirect()
            ->route('user.permohonan.show', $permohonan)
            ->with('success', 'Bukti pembayaran berhasil diperbarui. Menunggu verifikasi petugas.');
    }

    public function view(Permohonan $permohonan)
    {
        $this->authorize('view', $permohonan);

        $permohonan->loadMissing('buktiBayar');
        $bukti = $permohonan->buktiBayar;
        abort_if(!$bukti, 404);

        if (!Storage::disk('local')->exists($bukti->path)) {
            abort(404);
        }

        $stream = Storage::disk('local')->readStream($bukti->path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $bukti->mime,
            'Content-Disposition' => 'inline; filename="' . addslashes($bukti->original_name) . '"',
        ]);
    }

    public function download(Permohonan $permohonan)
    {
        $this->authorize('view', $permohonan);

        $permohonan->loadMissing('buktiBayar');
        $bukti = $permohonan->buktiBayar;
        abort_if(!$bukti, 404);

        abort_if(!Storage::disk('local')->exists($bukti->path), 404);

        return Storage::disk('local')->download($bukti->path, $bukti->original_name);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'bukti_bayar' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ]);
    }

    private function storeFile(Permohonan $permohonan, \Illuminate\Http\UploadedFile $file): string
    {
        return $file->store("bukti_bayar/{$permohonan->id}", 'local');
    }

    private function isUploadAllowed(Permohonan $permohonan): bool
    {
        return in_array($permohonan->status, self::ALLOWED_STATUSES, true);
    }

    private function notifyAdmins(Permohonan $permohonan): void
    {
        $admins = User::query()
            ->where('is_admin', 1)
            ->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new AdminBuktiBayarUploaded($permohonan));
        }
    }
}
