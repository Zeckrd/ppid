<x-layout>
    <div class="container mt-5 pt-5">
        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Pencarian Permohonan Informasi</h3>
                <p class="text-muted mb-0">Cari dan kelola permohonan informasi</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <form action="{{ route('admin.permohonan.search') }}" method="GET" id="filterForm">
                    
                    {{-- Top Row (Search + Buttons) --}}
                    <div class="d-flex flex-wrap gap-2 align-items-stretch">
                        <div class="flex-grow-1">
                            <div class="input-group rounded-pill shadow-sm">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="ri-search-line text-muted"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="q" 
                                    value="{{ request('q') }}" 
                                    class="form-control border-0" 
                                    placeholder="Cari nama, email, atau keterangan...">
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-secondary rounded-pill flex-grow-1 flex-md-grow-0" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#advancedFilter">
                                <i class="ri-filter-3-line me-1"></i> Filter Lanjutan
                            </button>

                            <button class="btn btn-primary rounded-pill px-4 flex-grow-1 flex-md-grow-0" type="submit">
                                <i class="ri-search-line me-1"></i> Cari
                            </button>
                        </div>
                    </div>

                    {{-- Collapsible Section --}}
                    <div class="collapse mt-3" id="advancedFilter">
                        
                        {{-- Date Range --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Pembuatan Permohonan</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control shadow-sm">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>

                        {{-- Quick Date Filters --}}
                        <div class="mb-3">
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary quick-date-btn" data-type="today">
                                    Hari Ini
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary quick-date-btn" data-type="week">
                                    Minggu Ini
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary quick-date-btn" data-type="month">
                                    Bulan Ini
                                </button>
                            </div>
                        </div>

                        {{-- Jenis Permohonan --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis Permohonan</label>
                            <select name="permohonan_type" class="form-select shadow-sm">
                                <option value="">Semua</option>
                                <option value="Biasa" {{ request('permohonan_type') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                <option value="Khusus" {{ request('permohonan_type') == 'Khusus' ? 'selected' : '' }}>Khusus</option>
                            </select>
                        </div>

                        {{-- Keberatan --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Memiliki Keberatan?</label>
                            <select name="has_keberatan" class="form-select shadow-sm">
                                <option value="">Semua</option>
                                <option value="ya" {{ request('has_keberatan') == 'ya' ? 'selected' : '' }}>Ya</option>
                                <option value="tidak" {{ request('has_keberatan') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                        </div>

                        {{-- Reset Filter Button --}}
                        <div class="mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-danger w-100 rounded-pill" id="resetFilters">
                                <i class="ri-refresh-line me-1"></i> Reset Semua Filter
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="status" value="{{ request('status') }}">
                </form>
            </div>
        </div>



        {{-- Active Filters Display --}}
        @if(request('q') || request('date_from') || request('date_to') || request('status') || request('permohonan_type') || request('has_keberatan'))
            <div class="mb-3">
                <small class="text-muted">Filter Aktif:</small>
                <div class="d-flex flex-wrap gap-2 mt-2">

                    {{-- Pencarian --}}
                    @if(request('q'))
                        <span class="badge bg-light text-dark border">
                            <i class="ri-search-line me-1"></i>Pencarian: "{{ request('q') }}"
                            <a href="{{ route('admin.permohonan.search', array_filter(request()->except('q'))) }}" class="text-dark ms-1">×</a>
                        </span>
                    @endif

                    {{-- Tanggal Dari --}}
                    @if(request('date_from'))
                        <span class="badge bg-light text-dark border">
                            <i class="ri-calendar-line me-1"></i>Dari: {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
                            <a href="{{ route('admin.permohonan.search', array_filter(request()->except('date_from'))) }}" class="text-dark ms-1">×</a>
                        </span>
                    @endif

                    {{-- Tanggal Sampai --}}
                    @if(request('date_to'))
                        <span class="badge bg-light text-dark border">
                            <i class="ri-calendar-line me-1"></i>Sampai: {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
                            <a href="{{ route('admin.permohonan.search', array_filter(request()->except('date_to'))) }}" class="text-dark ms-1">×</a>
                        </span>
                    @endif

                    {{-- Status --}}
                    @if(request('status') && request('status') != 'Semua')
                        <span class="badge bg-light text-dark border">
                            <i class="ri-filter-line me-1"></i>Status: {{ request('status') }}
                            <a href="{{ route('admin.permohonan.search', array_filter(request()->except('status'))) }}" class="text-dark ms-1">×</a>
                        </span>
                    @endif

                    {{-- Jenis Permohonan --}}
                    @if(request('permohonan_type'))
                        <span class="badge bg-light text-dark border">
                            <i class="ri-file-list-line me-1"></i>Jenis: {{ request('permohonan_type') }}
                            <a href="{{ route('admin.permohonan.search', array_filter(request()->except('permohonan_type'))) }}" class="text-dark ms-1">×</a>
                        </span>
                    @endif

                    {{-- Memiliki Keberatan --}}
                    @if(request('has_keberatan'))
                        <span class="badge bg-light text-dark border">
                            <i class="ri-error-warning-line me-1"></i>Keberatan: {{ ucfirst(request('has_keberatan')) }}
                            <a href="{{ route('admin.permohonan.search', array_filter(request()->except('has_keberatan'))) }}" class="text-dark ms-1">×</a>
                        </span>
                    @endif

                </div>
            </div>
        @endif


        {{-- FILTER STATUS --}}
        <div class="mb-4">
            <ul class="nav nav-pills flex-wrap">
                @php
                    $statuses = [
                        'Semua',
                        'Menunggu Verifikasi Berkas Dari Petugas',
                        'Sedang Diverifikasi petugas',
                        'Perlu Diperbaiki',
                        'Diproses',
                        'Diterima',
                        'Ditolak',
                    ];
                @endphp

                @foreach($statuses as $item)
                    @php
                        $active = (request('status') == $item || (request('status') == null && $item == 'Semua')) ? 'active' : '';

                        $params = request()->except('page', 'status');

                        if ($item !== 'Semua') {
                            $params['status'] = $item;
                        }
                    @endphp

                    <li class="nav-item mb-2 me-2">
                        <a class="nav-link {{ $active }}"
                        href="{{ route('admin.permohonan.search', $params) }}">
                            @switch($item)
                                @case('Semua')
                                    <i class="ri-file-list-3-line me-1"></i> Semua
                                    @break
                                @case('Menunggu Verifikasi Berkas Dari Petugas')
                                    <i class="ri-time-line me-1"></i> Menunggu Verifikasi
                                    @break
                                @case('Sedang Diverifikasi petugas')
                                    <i class="ri-search-eye-line me-1"></i> Diverifikasi
                                    @break
                                @case('Perlu Diperbaiki')
                                    <i class="ri-error-warning-line me-1"></i> Perlu Diperbaiki
                                    @break
                                @case('Diproses')
                                    <i class="ri-loader-4-line me-1"></i> Diproses
                                    @break
                                @case('Diterima')
                                    <i class="ri-checkbox-circle-line me-1"></i> Diterima
                                    @break
                                @case('Ditolak')
                                    <i class="ri-close-circle-line me-1"></i> Ditolak
                                    @break
                            @endswitch
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- SEARCH RESULTS --}}
        @if($permohonans->isEmpty())
            <div class="text-center py-5 my-5">
                <div class="mb-4">
                    <i class="ri-search-line" style="font-size: 4rem; color: #6c757d; opacity: 0.5;"></i>
                </div>
                <h5 class="mb-3">Tidak Ada Hasil Ditemukan</h5>
                <p class="text-muted mb-4">Coba gunakan kata kunci lain atau periksa ejaan Anda.</p>
            </div>
        @else
            <div class="card border-0 shadow-sm">
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 border-0">Pembaruan Terakhir</th>
                                <th class="px-4 py-3 border-0">Nama</th>
                                <th class="px-4 py-3 border-0">Jenis Permohonan</th>
                                <th class="px-4 py-3 border-0">Status</th>
                                <th class="px-4 py-3 border-0">Keberatan</th>
                                <th class="px-4 py-3 border-0 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permohonans as $permohonan)
                                <tr onclick="window.location='{{ route('admin.permohonan.show', $permohonan->id) }}';" style="cursor: pointer;">
                                    <td class="px-4 py-3 align-middle">
                                        <i class="ri-calendar-line text-muted me-2"></i>
                                        {{ $permohonan->updated_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <i class="ri-user-line text-muted me-2"></i>
                                        {{ $permohonan->user->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <span class="fw-medium">{{ ucfirst($permohonan->permohonan_type ?? '-') }}</span>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        @if($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
                                            <span class="badge bg-warning text-dark">
                                                <i class="ri-time-line me-1"></i> Menunggu Verifikasi
                                            </span>
                                        @elseif($permohonan->status == 'Sedang Diverifikasi petugas')
                                            <span class="badge bg-primary">
                                                <i class="ri-search-eye-line me-1"></i> Diverifikasi
                                            </span>
                                        @elseif($permohonan->status == 'Perlu Diperbaiki')
                                            <span class="badge bg-danger">
                                                <i class="ri-error-warning-line me-1"></i> Perlu Diperbaiki
                                            </span>
                                        @elseif($permohonan->status == 'Diproses')
                                            <span class="badge bg-info text-dark">
                                                <i class="ri-loader-4-line me-1"></i> Diproses
                                            </span>
                                        @elseif($permohonan->status == 'Diterima')
                                            <span class="badge bg-success">
                                                <i class="ri-checkbox-circle-line me-1"></i> Diterima
                                            </span>
                                        @elseif($permohonan->status == 'Ditolak')
                                            <span class="badge bg-danger">
                                                <i class="ri-close-circle-line"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="ri-information-line me-1"></i>{{ ucfirst($permohonan->status) }}
                                            </span>
                                        @endif
                                    </td>

                                {{-- Status Keberatan --}}
                                <td class="px-4 py-3 align-middle">
                                    @if ($permohonan->keberatan)
                                        @php
                                            $status = $permohonan->keberatan->status ?? 'Pending';
                                        @endphp
                                    @switch($status)
                                        @case('Pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="ri-time-line me-1"></i> Pending
                                            </span>
                                            @break

                                        @case('Diproses')
                                            <span class="badge bg-info text-dark">
                                                <i class="ri-loader-4-line me-1"></i> Diproses
                                            </span>
                                            @break

                                        @case('Diterima')
                                            <span class="badge bg-success">
                                                <i class="ri-checkbox-circle-line me-1"></i> Diterima
                                            </span>
                                            @break
                                        
                                        @case('Ditolak')
                                            <span class="badge bg-danger">
                                                <i class="ri-close-circle-line"></i> Ditolak
                                            </span>
                                            @break

                                        @default
                                            <span class="badge bg-secondary">
                                                <i class="ri-question-line me-1"></i> {{ ucfirst($status) }}
                                            </span>
                                    @endswitch

                                    @else
                                        <span class="text-muted">
                                            <i class="ri-close-circle-line me-1"></i> Tidak Ada
                                        </span>
                                    @endif

                                </td>
                                    <td class="px-4 py-3 text-end align-middle">
                                        <a href="{{ route('admin.permohonan.show', $permohonan->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           onclick="event.stopPropagation();">
                                            Lihat Detail
                                            <i class="ri-arrow-right-line ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Mobile Card View --}}
            <div class="d-lg-none">
                @foreach($permohonans as $permohonan)
                    <div class="card border-0 shadow-sm mb-3" 
                         onclick="window.location='{{ route('admin.permohonan.show', $permohonan->id) }}';" 
                         style="cursor: pointer;">
                        <div class="card-body p-3">
                            {{-- Header: Status + Keberatan Badge --}}
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    @if($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
                                        <span class="badge bg-warning text-dark small">
                                            <i class="ri-time-line me-1"></i>Menunggu
                                        </span>
                                    @elseif($permohonan->status == 'Sedang Diverifikasi petugas')
                                        <span class="badge bg-primary small">
                                            <i class="ri-search-eye-line me-1"></i>Diverifikasi
                                        </span>
                                    @elseif($permohonan->status == 'Perlu Diperbaiki')
                                        <span class="badge bg-danger small">
                                            <i class="ri-error-warning-line me-1"></i>Perlu Perbaikan
                                        </span>
                                    @elseif($permohonan->status == 'Diproses')
                                        <span class="badge bg-info text-dark small">
                                            <i class="ri-loader-4-line me-1"></i>Diproses
                                        </span>
                                    @elseif($permohonan->status == 'Diterima')
                                        <span class="badge bg-success small">
                                            <i class="ri-checkbox-circle-line me-1"></i>Diterima
                                        </span>
                                    @elseif($permohonan->status == 'Ditolak')
                                        <span class="badge bg-danger small">
                                            <i class="ri-close-circle-line"></i>Ditolak
                                        </span>
                                    @else
                                        <span class="badge bg-secondary small">{{ ucfirst($permohonan->status) }}</span>
                                    @endif
                                </div>
                                
                                @if($permohonan->keberatan && $permohonan->keberatan->count() > 0)
                                    <span class="badge bg-danger-subtle text-danger border border-danger small">
                                        <i class="ri-alert-line"></i>
                                    </span>
                                @endif
                            </div>

                            {{-- Pemohon Name --}}
                            <h6 class="mb-2 fw-semibold">
                                <i class="ri-user-line text-muted me-1"></i>
                                {{ $permohonan->user->name ?? '-' }}
                            </h6>

                            {{-- Info Grid --}}
                            <div class="row g-2 small text-muted mb-3">
                                <div class="col-6">
                                    <i class="ri-file-text-line me-1"></i>
                                    <span class="fw-medium text-dark">{{ ucfirst($permohonan->permohonan_type ?? '-') }}</span>
                                </div>
                                <div class="col-6 text-end">
                                    <i class="ri-calendar-line me-1"></i>
                                    {{ $permohonan->created_at->format('d M Y') }}
                                </div>
                            </div>

                            {{-- Action Button --}}
                            <a href="{{ route('admin.permohonan.show', $permohonan->id) }}" 
                               class="btn btn-outline-primary btn-sm w-100"
                               onclick="event.stopPropagation();">
                                Lihat Detail <i class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    {{ $permohonans->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/user-dashboard.css') }}">
    @endpush

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const dateFrom = form.querySelector('[name="date_from"]');
        const dateTo = form.querySelector('[name="date_to"]');
        const buttons = form.querySelectorAll('.quick-date-btn');
        const resetBtn = document.getElementById('resetFilters');
        const today = new Date();

        const formatDate = (date) => date.toISOString().split('T')[0];

        // --- Quick date buttons ---
        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Reset button visuals
                buttons.forEach(b => b.classList.remove('btn-secondary', 'active'));
                buttons.forEach(b => b.classList.add('btn-outline-secondary'));

                // Highlight the clicked button
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-secondary', 'active');

                // Apply date logic
                const type = this.dataset.type;
                let start = new Date(today);
                let end = new Date(today);

                if (type === 'week') {
                    start.setDate(today.getDate() - today.getDay() + 1);
                } else if (type === 'month') {
                    start = new Date(today.getFullYear(), today.getMonth(), 1);
                }

                dateFrom.value = formatDate(start);
                dateTo.value = formatDate(end);
            });
        });

        // --- Reset button ---
        resetBtn.addEventListener('click', function() {
            // Clear all inputs manually
            form.querySelectorAll('input, select').forEach(el => {
                if (el.type === 'text' || el.type === 'date' || el.tagName === 'SELECT') {
                    el.value = '';
                }
            });

            // Reset quick-date button visuals
            buttons.forEach(b => {
                b.classList.remove('btn-secondary', 'active');
                b.classList.add('btn-outline-secondary');
            });

            // Remove all query parameters and reload
            const baseUrl = form.getAttribute('action');
            window.location.href = baseUrl;
        });
    });
    </script>
    @endpush


</x-layout>