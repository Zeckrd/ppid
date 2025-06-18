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

    public function show(Permohonan $permohonan)
    {
        return view('dashboard.show', compact('permohonan'));
    }

    public function edit(Permohonan $permohonan)
    {
        return view('dashboard.edit', compact('permohonan'));
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'permohonan_type' => 'required|in:biasa,khusus',
            'keterangan_user' => 'required|string',
            'reply_type' => 'required|in:softcopy,hardcopy',
            'permohonan_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $updateData = [
            'permohonan_type' => $request->permohonan_type,
            'keterangan_user' => $request->keterangan_user,
            'reply_type' => $request->reply_type,
        ];


        if ($request->hasFile('permohonan_file')) {

            if ($permohonan->permohonan_file && Storage::disk('public')->exists($permohonan->permohonan_file)) {
                Storage::disk('public')->delete($permohonan->permohonan_file);
            }
            
            $updateData['permohonan_file'] = $request->file('permohonan_file')->store('permohonan', 'public');
        }


        if ($permohonan->status == 'Perlu Diperbaiki') {
            $updateData['status'] = 'Menunggu Verifikasi Berkas Dari Petugas';
            $updateData['keterangan_petugas'] = null;
        }

        $permohonan->update($updateData);

        return redirect()->route('dashboard.show', $permohonan)
                       ->with('success', 'Permohonan berhasil diperbarui.');
    }
}
