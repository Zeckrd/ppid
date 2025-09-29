<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        return view('user.dashboard.index', compact('permohonans'));
    }
}
