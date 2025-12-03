<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', 'all');
        
        // base query filters
        $permohonanQuery = Permohonan::query();
        $keberatanQuery = Keberatan::query();
        
        if ($month !== 'all') {
            $permohonanQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
            $keberatanQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } else {
            $permohonanQuery->whereYear('created_at', $year);
            $keberatanQuery->whereYear('created_at', $year);
        }
        
        // filter users based on year/month
        $userQuery = User::query();
        if ($month !== 'all') {
            $userQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } else {
            $userQuery->whereYear('created_at', $year);
        }
        
        $totalUsers = $userQuery->count();
        $totalPermohonan = $permohonanQuery->count();
        $totalKeberatan = $keberatanQuery->count();
        
        // filter "Sedang Berlangsung" based on year/month
        $totalActiveQuery = Permohonan::whereIn('status', [
            'Menunggu Verifikasi Berkas Dari Petugas',
            'Sedang Diverifikasi petugas',
            'Permohonan Sedang Diproses',
        ]);
        
        if ($month !== 'all') {
            $totalActiveQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } else {
            $totalActiveQuery->whereYear('created_at', $year);
        }
        
        $totalActive = $totalActiveQuery->count();
        
        // status distribution for chart (filtered)
        $statuses = [
            'Menunggu Verifikasi Berkas Dari Petugas',
            'Sedang Diverifikasi petugas',
            'Perlu Diperbaiki',
            'Diproses',
            'Diterima',
            'Ditolak'
        ];
        
        $statusCounts = [];
        foreach ($statuses as $status) {
            $query = Permohonan::where('status', $status);
            if ($month !== 'all') {
                $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
            } else {
                $query->whereYear('created_at', $year);
            }
            $statusCounts[$status] = $query->count();
        }
        
        // monthly trend (whole year)
        $monthlyData = collect(range(1, 12))->map(function ($m) use ($year) {
            return [
                'month' => $m,
                'monthLabel' => date('M', mktime(0, 0, 0, $m, 1)),
                'permohonan' => Permohonan::whereYear('created_at', $year)->whereMonth('created_at', $m)->count(),
                'keberatan' => Keberatan::whereYear('created_at', $year)->whereMonth('created_at', $m)->count(),
            ];
        });
        
        // daily trend for selected month
        if ($month !== 'all') {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $dailyData = collect(range(1, $daysInMonth))->map(function ($d) use ($month, $year) {
                return [
                    'day' => $d,
                    'permohonan' => Permohonan::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->whereDay('created_at', $d)
                        ->count(),
                    'keberatan' => Keberatan::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->whereDay('created_at', $d)
                        ->count(),
                ];
            });
        } else {
            $dailyData = collect([]);
        }

        // Pekerjaan count
        $pekerjaanStats = User::select('pekerjaan', DB::raw('COUNT(*) as total'))
            ->whereNotNull('pekerjaan')
            ->where('is_admin', false)
            ->groupBy('pekerjaan')
            ->orderBy('pekerjaan')
            ->get();

        $pekerjaanLabels = $pekerjaanStats->pluck('pekerjaan');
        $pekerjaanCounts = $pekerjaanStats->pluck('total');
        
        $pendingPermohonanQuery = Permohonan::whereIn('status', [
            'Menunggu Verifikasi Berkas Dari Petugas',
            'Sedang Diverifikasi petugas',
            'Permohonan Sedang Diproses',
        ]);
        
        if ($month !== 'all') {
            $pendingPermohonanQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } else {
            $pendingPermohonanQuery->whereYear('created_at', $year);
        }
        
        $pendingPermohonan = $pendingPermohonanQuery->latest()->paginate(5);
        
        return view('admin.dashboard', compact(
            'year', 'month',
            'totalUsers', 'totalPermohonan', 'totalKeberatan', 'totalActive',
            'statuses', 'statusCounts', 'monthlyData', 'dailyData', 'pendingPermohonan',
            'pekerjaanLabels','pekerjaanCounts'
        ));
    }
}