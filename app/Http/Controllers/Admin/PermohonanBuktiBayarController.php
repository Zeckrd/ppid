<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;

class PermohonanBuktiBayarController extends Controller
{
    public function view(Permohonan $permohonan)
    {
        $bukti = $permohonan->buktiBayar;
        abort_if(!$bukti, 404);

        abort_if(!Storage::disk('local')->exists($bukti->path), 404);

        $stream = Storage::disk('local')->readStream($bukti->path);
        abort_if($stream === false, 404);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) fclose($stream);
        }, 200, [
            'Content-Type' => $bukti->mime ?? 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . $this->safeFilename($bukti->original_name) . '"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function download(Permohonan $permohonan)
    {
        $bukti = $permohonan->buktiBayar;
        abort_if(!$bukti, 404);

        abort_if(!Storage::disk('local')->exists($bukti->path), 404);

        return Storage::disk('local')->download(
            $bukti->path,
            $bukti->original_name ?? ('bukti-bayar-' . $permohonan->id)
        );
    }

    private function safeFilename(?string $name): string
    {
        $name = $name ?: 'file';
        return str_replace(["\r", "\n", '"', '\\'], '', $name);
    }
}
