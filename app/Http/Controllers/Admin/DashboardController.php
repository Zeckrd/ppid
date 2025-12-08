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

        // filter year 
        $year = $yearParam === 'semua' ? null : (int) $yearParam;

        // year used for charts
        $chartYear = $year ?? now()->year;

        $dateFrom = null;
        $dateTo   = null;
        $start    = null;
        $end      = null;

        // queries (for cards)
        $permohonanQuery = Permohonan::query();
        $keberatanQuery  = Keberatan::query();

        $attentionStatuses = [
            'Menunggu Verifikasi Berkas Dari Petugas',
            'Sedang Diverifikasi petugas',
            'Permohonan Sedang Diproses',
        ];

        $activeQuery = Permohonan::whereIn('status', $attentionStatuses);

        // If year is selected, apply year/monthfilter
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

            // cumulative users up to end of range
            $totalUsers = User::whereDate('created_at', '<=', $dateTo)->count();
        } else {
            // SEMUA WAKTU
            $totalUsers = User::count();
        }

        $totalPermohonan = $permohonanQuery->count();
        $totalKeberatan  = $keberatanQuery->count();
        $totalActive     = $activeQuery->count();

        // CHARTS

        // Status distribution (follow filter if year selected, else use chartYear)
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

            if ($year !== null) {
                // If filter year is selected, match the same range as cards
                if ($month !== 'semua' && $start && $end) {
                    $query->whereBetween('created_at', [$start, $end]);
                } else {
                    $query->whereYear('created_at', $year);
                }
            } else {
                // No filter = show distribution for current year
                $query->whereYear('created_at', $chartYear);
            }

            $statusCounts[$status] = $query->count();
        }

        // Monthly trend
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

        // Pekerjaan count
        $pekerjaanStats = User::select('pekerjaan', DB::raw('COUNT(*) as total'))
            ->whereNotNull('pekerjaan')
            ->where('is_admin', false)
            ->groupBy('pekerjaan')
            ->orderBy('pekerjaan')
            ->get();

        $pekerjaanLabels = $pekerjaanStats->pluck('pekerjaan');
        $pekerjaanCounts = $pekerjaanStats->pluck('total');

        // Pending permohonan list
        $pendingPermohonanQuery = Permohonan::whereIn('status', $attentionStatuses);

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
