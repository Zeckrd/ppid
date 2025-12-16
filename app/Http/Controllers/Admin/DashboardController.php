<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // "Semua" default
        $yearParam = $request->input('year', 'semua');
        $month     = $request->input('month', 'semua');

        // Filter year
        $year = $yearParam === 'semua' ? null : (int) $yearParam;

        // Year used for charts (when no filter, show current year)
        $chartYear = $year ?? now()->year;

        $dateFrom = null;
        $dateTo   = null;
        $start    = null;
        $end      = null;

        // Base queries (for cards)
        $permohonanQuery = Permohonan::query();
        $keberatanQuery  = Keberatan::query();

        // "active" group
        $activeStatuses = [
            'Menunggu Verifikasi Berkas Dari Petugas',
            'Sedang Diverifikasi petugas',
            'Diproses',
        ];

        $activeQuery = Permohonan::whereIn('status', $activeStatuses);

        // If year is selected, apply year/month filter
        if ($year !== null) {
            if ($month !== 'semua') {
                $monthInt = (int) $month;
                $start    = Carbon::create($year, $monthInt, 1)->startOfDay();
                $end      = (clone $start)->endOfMonth()->endOfDay();
            } else {
                $start = Carbon::create($year, 1, 1)->startOfDay();
                $end   = Carbon::create($year, 12, 31)->endOfDay();
            }

            $dateFrom = $start->toDateString();
            $dateTo   = $end->toDateString();

            $permohonanQuery->whereBetween('created_at', [$start, $end]);
            $keberatanQuery->whereBetween('created_at', [$start, $end]);
            $activeQuery->whereBetween('created_at', [$start, $end]);

            // Cumulative users up to end of selected range
            $totalUsers = User::where('is_admin', 0)
                ->whereDate('created_at', '<=', $dateTo)
                ->count();
        } else {
            // SEMUA WAKTU
            $totalUsers = User::where('is_admin', 0)->count();
        }

        // Cards
        $totalPermohonan = $permohonanQuery->count();
        $totalKeberatan  = $keberatanQuery->count();
        $totalActive     = $activeQuery->count();

        // CHARTS

        // Status distribution
        $statuses = [
            'Menunggu Verifikasi Berkas Dari Petugas',
            'Sedang Diverifikasi petugas',
            'Perlu Diperbaiki',
            'Diproses',
            'Diterima',
            'Ditolak',
        ];

        $statusCounts = [];
        foreach ($statuses as $status) {
            $q = Permohonan::where('status', $status);

            if ($year !== null) {
                // If filter year is selected, match the same range as cards
                if ($month !== 'semua' && $start && $end) {
                    $q->whereBetween('created_at', [$start, $end]);
                } else {
                    $q->whereYear('created_at', $year);
                }
            } else {
                // No filter = show distribution for current year
                $q->whereYear('created_at', $chartYear);
            }

            $statusCounts[$status] = $q->count();
        }

        // Monthly trend (always based on $chartYear)
        $monthlyData = collect(range(1, 12))->map(function ($m) use ($chartYear) {
            return [
                'month'      => $m,
                'monthLabel' => date('M', mktime(0, 0, 0, $m, 1)),
                'permohonan' => Permohonan::whereYear('created_at', $chartYear)
                    ->whereMonth('created_at', $m)
                    ->count(),
                'keberatan'  => Keberatan::whereYear('created_at', $chartYear)
                    ->whereMonth('created_at', $m)
                    ->count(),
            ];
        });

        // Daily trend for selected month (only when filter year + month selected)
        if ($year !== null && $month !== 'semua') {
            $monthInt    = (int) $month;
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthInt, $year);

            $dailyData = collect(range(1, $daysInMonth))->map(function ($d) use ($monthInt, $year) {
                return [
                    'day'        => $d,
                    'permohonan' => Permohonan::whereYear('created_at', $year)
                        ->whereMonth('created_at', $monthInt)
                        ->whereDay('created_at', $d)
                        ->count(),
                    'keberatan'  => Keberatan::whereYear('created_at', $year)
                        ->whereMonth('created_at', $monthInt)
                        ->whereDay('created_at', $d)
                        ->count(),
                ];
            });
        } else {
            $dailyData = collect([]);
        }

        // Pekerjaan count (exclude admin)
        $pekerjaanStats = User::select('pekerjaan', DB::raw('COUNT(*) as total'))
            ->whereNotNull('pekerjaan')
            ->where('is_admin', false)
            ->groupBy('pekerjaan')
            ->orderBy('pekerjaan')
            ->get();

        $pekerjaanLabels = $pekerjaanStats->pluck('pekerjaan');
        $pekerjaanCounts = $pekerjaanStats->pluck('total');

        // "Active" permohonan list
        $pendingPermohonanQuery = Permohonan::whereIn('status', $activeStatuses);

        if ($start && $end) {
            $pendingPermohonanQuery->whereBetween('created_at', [$start, $end]);
        }

        $pendingPermohonan = $pendingPermohonanQuery->latest()->paginate(5);

        return view('admin.dashboard', [
            // UI filter values
            'year'  => $yearParam,
            'month' => $month,

            // Date range
            'dateFrom' => $dateFrom,
            'dateTo'   => $dateTo,

            // Cards
            'totalUsers'      => $totalUsers,
            'totalPermohonan' => $totalPermohonan,
            'totalKeberatan'  => $totalKeberatan,
            'totalActive'     => $totalActive,

            // Charts
            'statuses'          => $statuses,
            'statusCounts'      => $statusCounts,
            'monthlyData'       => $monthlyData,
            'dailyData'         => $dailyData,
            'pendingPermohonan' => $pendingPermohonan,
            'pekerjaanLabels'   => $pekerjaanLabels,
            'pekerjaanCounts'   => $pekerjaanCounts,
        ]);
    }
}
