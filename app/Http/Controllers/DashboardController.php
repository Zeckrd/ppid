<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $permohonans = Permohonan::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('dashboard.index', [
            'permohonans' => $permohonans
        ]);
    }

    public function create()
    {
        return view('dashboard.create');
        
    }

    public function store()
    {
        request()->validate([
            'permohonan_type' => 'required|in:biasa,khusus',
            'permohonan_file' => 'required|file|mimes:pdf,doc,docx|max:2048',//DONOT SET MAX ABOVE 2MB UNLESS PHP CONFIG CHANGE
            'keterangan_user' => 'required|string|max:512',
            'reply_type' => 'required|in:softcopy,hardcopy',
        ]);


        $path = request()->file('permohonan_file')->store('permohonan', 'public');

        Permohonan::create([
            'user_id' => auth()->id(),
            'permohonan_type' => request('permohonan_type'),
            'permohonan_file' => $path,
            'keterangan_user' => request('keterangan_user'),
            'reply_type' => request('reply_type'),
        ]);

        return redirect('/dashboard');
    }

    public function show($id)
    {
        $permohonan = Permohonan::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        return view('dashboard.show', compact('permohonan'));
    }

    public function edit($id)
    {
        $permohonan = Permohonan::where('id', $id)
                               ->where('user_id', auth()->id())
                               ->firstOrFail();

        // If status is at menunggu verifikasi or perlu diperbaiki enable edit
        if (!in_array($permohonan->status, ['Menunggu Verifikasi Berkas Dari Petugas', 'Perlu Diperbaiki'])) {
            return redirect()->route('dashboard.show', $permohonan->id)
                           ->with('error', 'Permohonan tidak dapat diedit pada status ini.');
        }

        return view('dashboard.edit', compact('permohonan'));
    }

    public function update(Request $request, $id)
    {
        $permohonan = Permohonan::where('id', $id)
                               ->where('user_id', auth()->id())
                               ->firstOrFail();

        // if status is at menunggu verifikasi or perlu diperbaiki enable edit
        if (!in_array($permohonan->status, ['Menunggu Verifikasi Berkas Dari Petugas', 'Perlu Diperbaiki'])) {
            return redirect()->route('dashboard.show', $permohonan->id)
                           ->with('error', 'Permohonan tidak dapat diedit pada status ini.');
        }

        $request->validate([
            'permohonan_type' => 'required|in:biasa,khusus',
            'keterangan_user' => 'required|string',
            'reply_type' => 'required|in:softcopy,hardcopy',
            'permohonan_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $updateData = [
            'permohonan_type' => $request->permohonan_type,
            'keterangan_user' => $request->keterangan_user,
            'reply_type' => $request->reply_type,
        ];

        // if user uploads a new file delete old file then store new file
        if ($request->hasFile('permohonan_file')) {
            if ($permohonan->permohonan_file && Storage::exists($permohonan->permohonan_file)) {
                Storage::delete($permohonan->permohonan_file);
            }
            
            $updateData['permohonan_file'] = $request->file('permohonan_file')->store('permohonan_files');
        }

        // reset status to Menunggu Verifikasi if it was Perlu Diperbaiki
        if ($permohonan->status == 'Perlu Diperbaiki') {
            $updateData['status'] = 'Menunggu Verifikasi Berkas Dari Petugas';
            $updateData['keterangan_petugas'] = null; // delete staff comment
        }

        $permohonan->update($updateData);

        return redirect()->route('dashboard.show', $permohonan->id)
                       ->with('success', 'Permohonan berhasil diperbarui.');
    }
}
