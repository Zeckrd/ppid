<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Permohonan;

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
            'permohonan_file' => 'required|file|mimes:pdf,doc,docx|max:4096',//DONOT SET MAX ABOVE 5MB
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

    public function edit()
    {
        if (Auth::guest()){
            return redirect('/login');
        }
    }

}
