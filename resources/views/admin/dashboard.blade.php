<x-layout>
    <div class="container py-4 pt-5 mt-4">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('admin.dashboard.index') }}" class="mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-end">
                        {{-- year + month + button --}}
                        <div class="row g-2 align-items-end">
                            
                        {{-- year select --}}
                        <div class="col-12 col-md-auto">
                            <div class="input-group input-group-sm w-100">
                            <span class="input-group-text" id="label-year">
                                <i class="ri-time-line"></i>
                            </span>
                            <select name="year" id="year" class="form-select form-select-sm" aria-labelledby="label-year">
                                <option value="semua" {{ $year === 'semua' ? 'selected' : '' }}>Semua Tahun</option>
                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                <option value="{{ $y }}" {{ (string)$year === (string)$y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                                @endfor
                            </select>
                            </div>
                        </div>

                        {{-- month select --}}
                        <div class="col-12 col-md-auto">
                            <div class="input-group input-group-sm w-100">
                            <span class="input-group-text" id="label-month">
                                <i class="ri-calendar-line"></i>
                            </span>
                            <select name="month" id="month" class="form-select form-select-sm"
                                    aria-labelledby="label-month"
                                    {{ $year === 'semua' ? 'disabled' : '' }}>
                                <option value="semua" {{ $month === 'semua' ? 'selected' : '' }}>Semua Bulan</option>
                                @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>
                                    {{ date('M', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        {{-- apply --}}
                        <div class="col-6 col-md-auto d-grid">
                            <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center">
                            <i class="ri-filter-3-line me-1"></i> Terapkan
                            </button>
                        </div>

                        {{-- reset --}}
                        @if ($year)
                            <div class="col-6 col-md-auto d-grid">
                            <a href="{{ route('admin.dashboard.index') }}"
                                class="btn btn-sm btn-danger d-flex align-items-center justify-content-center">
                                <i class="ri-refresh-line me-1"></i> Reset
                            </a>
                            </div>
                        @endif

                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                        <a href="{{ route('admin.permohonan.search', [
                        'date_from' => $dateFrom,
                        'date_to'   => $dateTo,
                    ]) }}"
                class="text-decoration-none">
                    <div class="card border-0 shadow-sm bg-primary text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-semibold mb-1">Total User</h6>
                                <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                            </div>
                            <i class="ri-user-3-line display-5 opacity-75"></i>
                        </div>
                    </div>
                </a>
            </div>

            @php
                $activeStatuses = [
                    'Menunggu Verifikasi Berkas Dari Petugas',
                    'Sedang Diverifikasi petugas',
                    'Diproses',
                ];
            @endphp

            <div class="col-md-3">
                <a href="{{ route('admin.permohonan.search', array_filter([
                        'date_from' => $dateFrom,
                        'date_to'   => $dateTo,
                        'statuses'  => $activeStatuses,
                    ])) }}"
                class="text-decoration-none">
                    <div class="card border-0 shadow-sm bg-info text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-semibold mb-1 text-white">Sedang Berlangsung</h6>
                                <h2 class="fw-bold mb-0 text-white">{{ $totalActive }}</h2>
                            </div>
                            <i class="ri-timer-2-line display-5 opacity-75"></i>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-md-3">
                <a href="{{ route('admin.permohonan.search', [
                        'date_from' => $dateFrom,
                        'date_to'   => $dateTo,
                    ]) }}"
                class="text-decoration-none">
                    <div class="card border-0 shadow-sm bg-success text-white">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-semibold mb-1 text-white">Total Permohonan</h6>
                                <h2 class="fw-bold mb-0 text-white">{{ $totalPermohonan }}</h2>
                            </div>
                            <i class="ri-file-list-3-line display-5 opacity-75"></i>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-md-3">
                <a href="{{ route('admin.permohonan.search', [
                        'date_from'     => $dateFrom,
                        'date_to'       => $dateTo,
                        'has_keberatan' => 'ya',
                    ]) }}"
                class="text-decoration-none">
                    <div class="card border-0 shadow-sm bg-warning text-dark">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-semibold mb-1">Total Keberatan</h6>
                                <h2 class="fw-bold mb-0">{{ $totalKeberatan }}</h2>
                            </div>
                            <i class="ri-error-warning-line display-5 opacity-75"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Charts --}}
        {{-- Distribusi status --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold d-flex align-items-center">
                        <i class="ri-pie-chart-2-line me-2 text-primary"></i> Distribusi Status
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            {{-- Tren pengajuan --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold d-flex align-items-center">
                        @if($month === 'semua')
                            <i class="ri-line-chart-line me-2 text-success"></i> Tren Pengajuan Bulanan ({{ $year }})
                        @else
                            <i class="ri-calendar-event-line me-2 text-success"></i> Tren Pengajuan Harian — {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}
                        @endif
                    </div>
                    <div class="card-body" style="height: 333px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- pie chart pekerjaan --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold d-flex align-items-center">
                <i class="ri-user-2-line me-2 text-info"></i> Distribusi Pekerjaan User
            </div>
            <div class="card-body d-flex justify-content-center align-items-center" style="height: 333px;">
                <div class="pekerjaan-chart-wrapper">
                    <canvas id="pekerjaanChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Pending / Sedang Berlangsung --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold d-flex align-items-center">
                <i class="ri-notification-3-line me-2 text-danger"></i> Pending / Sedang Berlangsung
            </div>
            <div class="card-body">
                @if($pendingPermohonan->count() > 0)
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($pendingPermohonan as $p)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $p->judul ?? 'Permohonan #' . $p->id }}</strong><br>
                                    <small class="text-muted">
                                        <i class="ri-time-line me-1"></i>{{ $p->status }} —
                                        {{ $p->created_at->format('d M Y') }}
                                    </small>
                                </div>
                                <a href="{{ route('admin.permohonan.show', $p->id) }}" class="btn btn-sm btn-outline-primary">
                                    Lihat Detail
                                    <i class="ri-arrow-right-line ms-1"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-end">
                        {{ $pendingPermohonan->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-muted mb-0">Tidak ada permohonan yang sedang berlangsung saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            window.dashboardData = {
                statusLabels: {!! json_encode($statuses) !!},
                statusData: {!! json_encode(array_map(fn($s) => $statusCounts[$s] ?? 0, $statuses)) !!},

                isMonthly: "{{ $month }}" === "semua",
                monthlyLabels: {!! json_encode($monthlyData->pluck('monthLabel')) !!},
                monthlyPermohonan: {!! json_encode($monthlyData->pluck('permohonan')) !!},
                monthlyKeberatan: {!! json_encode($monthlyData->pluck('keberatan')) !!},


                dailyLabels: {!! json_encode($dailyData->pluck('day') ?? []) !!},
                dailyPermohonan: {!! json_encode($dailyData->pluck('permohonan') ?? []) !!},
                dailyKeberatan: {!! json_encode($dailyData->pluck('keberatan') ?? []) !!},

                pekerjaanLabels: {!! json_encode($pekerjaanLabels ?? []) !!},
                pekerjaanCounts: {!! json_encode($pekerjaanCounts ?? []) !!}
            };
        </script>

        <script src="{{ asset('js/admin-dashboard.js') }}"></script>
    @endpush
</x-layout>