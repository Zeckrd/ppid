<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status'); // e.g., ?status=Menunggu

        $query = Permohonan::with('user')
            ->where('user_id', $user->id);

        // Apply filter only if 'status' query is present and not 'Semua'
        if ($status && $status !== 'Semua') {
            $query->where('status', $status);
        }

        $permohonans = $query->latest()->paginate(10)->withQueryString();

        return view('user.dashboard.index', compact('permohonans', 'status'));
    }

}
