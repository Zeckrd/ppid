<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusUpdateMail;
use App\Services\WablasService;
use Illuminate\Support\Arr;


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
        $permohonan->load('user', 'keberatan');

        return view('admin.permohonan.show', compact('permohonan'));
    }

    /**
     * Update permohonan (status, petugas notes, reply file).
     */
    public function update(Request $request, Permohonan $permohonan, WablasService $wablas)
    {
        $validated = $request->validate([
            'status'             => 'required|string',
            'keterangan_petugas' => 'nullable|string|max:1000',
            'reply_file'         => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'notify_whatsapp'    => 'nullable|boolean',
            'notify_email'       => 'nullable|boolean',
        ]);

        // Handle reply file upload
        if ($request->hasFile('reply_file')) {
            if ($permohonan->reply_file && Storage::disk('public')->exists($permohonan->reply_file)) {
                Storage::disk('public')->delete($permohonan->reply_file);
            }

            $validated['reply_file'] = $request->file('reply_file')->store('reply_files', 'public');
        }

        // Update data
        $permohonan->update(Arr::except($validated, ['notify_whatsapp', 'notify_email']));


        // Create message
        $message = "Status Permohonan Anda telah diperbarui menjadi: *{$permohonan->status}*.\n";

        if ($permohonan->keberatan) {
            $message .= "Status Keberatan: {$permohonan->keberatan->status}\n";
        }

        if ($permohonan->keterangan_petugas) {
            $message .= "Keterangan Petugas: {$permohonan->keterangan_petugas}\n";
        }

        $message .= "\nTerima kasih telah menggunakan layanan kami.";

        // Send WhatsApp notification
        if ($request->boolean('notify_whatsapp')) {
            $wablas->sendMessage($permohonan->user->phone, $message);
        }

        // Send Email notification
        if ($request->boolean('notify_email')) {
            Mail::to($permohonan->user->email)->send(new StatusUpdateMail($permohonan, $message));
        }

        return redirect()
            ->route('admin.permohonan.show', $permohonan->id)
            ->with('success', 'Permohonan berhasil diperbarui.');
    }
    public function search(Request $request)
    {
        $keyword  = $request->input('q');
        $status   = $request->input('status');
        $type    = $request->input('permohonan_type');
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

        // Filter by status
        if ($status && $status !== 'Semua') {
            $query->where('status', $status);
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

        // Filter by keberatan existence
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
 
}
