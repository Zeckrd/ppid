<x-layout>
    <div class="container mt-5 pt-5">
        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Pencarian Permohonan Informasi</h3>
                <p class="text-muted mb-0">Cari dan kelola permohonan informasi</p>
            </div>
        </div>

        {{-- FILTER TOOLBAR --}}
        @php
            $hasAdvanced =
                request('date_from') || request('date_to') ||
                request('permohonan_type') || request('has_keberatan');

            $multiStatuses = (array) request('statuses', []);
            $multiStatuses = array_values(array_filter($multiStatuses));

            $hasAny =
                request('q') || request('date_from') || request('date_to') ||
                (request('status') && request('status') !== 'Semua') ||
                !empty($multiStatuses) ||
                request('permohonan_type') || request('has_keberatan');
        @endphp

            {{-- FILTER TOOLBAR --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('admin.permohonan.search') }}" method="GET" id="filterForm" class="vstack gap-3">

                    {{-- Top row: Search + Actions --}}
                    <div class="d-flex flex-column flex-md-row gap-2 align-items-stretch">

                        {{-- Search --}}
                        <div class="flex-grow-1">
                        <div class="input-group bg-light rounded-pill px-2">
                            <span class="input-group-text bg-transparent border-0">
                            <i class="ri-search-line text-muted"></i>
                            </span>
                            <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            class="form-control bg-transparent border-0"
                            placeholder="Cari nama, email, atau keterangan..."
                            aria-label="Pencarian"
                            >
                            @if(request('q'))
                            <a class="btn btn-sm btn-link text-muted"
                                href="{{ route('admin.permohonan.search', array_filter(request()->except('q','page'))) }}"
                                aria-label="Hapus pencarian">
                                <i class="ri-close-line"></i>
                            </a>
                            @endif
                        </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-rsq"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#advancedFilter"
                                aria-expanded="{{ $hasAdvanced ? 'true' : 'false' }}"
                                aria-controls="advancedFilter">
                            <i class="ri-filter-3-line me-1"></i> Filter Lanjutan
                        </button>

                        <button class="btn btn-primary btn-rsq px-4" type="submit">
                            <i class="ri-search-line me-1"></i> Terapkan
                        </button>
                        </div>
                    </div>

                    {{-- Active filter chips --}}
                    @if($hasAny)
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                        <small class="text-muted me-1">Filter aktif:</small>

                        @if(request('q'))
                            <span class="badge rounded-pill bg-light text-dark border py-2 px-3">
                            <i class="ri-search-line me-1 text-muted"></i>
                            {{ \Illuminate\Support\Str::limit(request('q'), 40) }}
                            <a class="text-dark ms-2"
                                href="{{ route('admin.permohonan.search', array_filter(request()->except('q','page'))) }}"
                                aria-label="Hapus pencarian">×</a>
                            </span>
                        @endif

                        @if(request('date_from'))
                            <span class="badge rounded-pill bg-light text-dark border py-2 px-3">
                            <i class="ri-calendar-line me-1 text-muted"></i>
                            Dari {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
                            <a class="text-dark ms-2"
                                href="{{ route('admin.permohonan.search', array_filter(request()->except('date_from','page'))) }}"
                                aria-label="Hapus tanggal dari">×</a>
                            </span>
                        @endif

                        @if(request('date_to'))
                            <span class="badge rounded-pill bg-light text-dark border py-2 px-3">
                            <i class="ri-calendar-line me-1 text-muted"></i>
                            Sampai {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
                            <a class="text-dark ms-2"
                                href="{{ route('admin.permohonan.search', array_filter(request()->except('date_to','page'))) }}"
                                aria-label="Hapus tanggal sampai">×</a>
                            </span>
                        @endif

                        @if(!empty($multiStatuses))
                            <span class="badge rounded-pill bg-light text-dark border py-2 px-3">
                            <i class="ri-filter-line me-1 text-muted"></i>
                            Status: {{ implode(', ', $multiStatuses) }}
                            <a class="text-dark ms-2"
                                href="{{ route('admin.permohonan.search', array_filter(request()->except('statuses','page'))) }}"
                                aria-label="Hapus status multi">×</a>
                            </span>
                        @elseif(request('status') && request('status') !== 'Semua')
                            <span class="badge rounded-pill bg-light text-dark border py-2 px-3">
                            <i class="ri-filter-line me-1 text-muted"></i>
                            Status: {{ request('status') }}
                            <a class="text-dark ms-2"
                                href="{{ route('admin.permohonan.search', array_filter(request()->except('status','page'))) }}"
                                aria-label="Hapus status">×</a>
                            </span>
                        @endif

                        @if(request('permohonan_type'))
                            <span class="badge rounded-pill bg-light text-dark border py-2 px-3">
                            <i class="ri-file-list-line me-1 text-muted"></i>
                            Jenis: {{ request('permohonan_type') }}
                            <a class="text-dark ms-2"
                                href="{{ route('admin.permohonan.search', array_filter(request()->except('permohonan_type','page'))) }}"
                                aria-label="Hapus jenis">×</a>
                            </span>
                        @endif

                        @if(request('has_keberatan'))
                            <span class="badge rounded-pill bg-light text-dark border py-2 px-3">
                            <i class="ri-error-warning-line me-1 text-muted"></i>
                            Keberatan: {{ ucfirst(request('has_keberatan')) }}
                            <a class="text-dark ms-2"
                                href="{{ route('admin.permohonan.search', array_filter(request()->except('has_keberatan','page'))) }}"
                                aria-label="Hapus keberatan">×</a>
                            </span>
                        @endif
                        </div>
                    @endif

                    {{-- Advanced Filters --}}
                    <div class="collapse {{ $hasAdvanced ? 'show' : '' }}" id="advancedFilter">
                        <div class="p-3 p-md-4 bg-light border rounded-4 mt-1">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="fw-semibold">
                            <i class="ri-equalizer-2-line me-1"></i> Filter Lanjutan
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-lg-6">
                            <label class="form-label fw-semibold">Tanggal Pembuatan</label>
                            <div class="row g-2">
                                <div class="col-12 col-md-6">
                                <input type="date" name="date_from" value="{{ request('date_from') }}"
                                        class="form-control shadow-sm" id="dateFrom">
                                </div>
                                <div class="col-12 col-md-6">
                                <input type="date" name="date_to" value="{{ request('date_to') }}"
                                        class="form-control shadow-sm" id="dateTo">
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-rsq quick-date-btn" data-type="today">Hari Ini</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-rsq quick-date-btn" data-type="week">Minggu Ini</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-rsq quick-date-btn" data-type="month">Bulan Ini</button>
                            </div>
                            </div>

                            <div class="col-12 col-lg-3">
                            <label class="form-label fw-semibold">Jenis Permohonan</label>
                            <select name="permohonan_type" class="form-select shadow-sm">
                                <option value="">Semua</option>
                                <option value="Biasa" {{ request('permohonan_type') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                <option value="Khusus" {{ request('permohonan_type') == 'Khusus' ? 'selected' : '' }}>Khusus</option>
                            </select>
                            </div>

                            <div class="col-12 col-lg-3">
                            <label class="form-label fw-semibold">Memiliki Keberatan?</label>
                            <select name="has_keberatan" class="form-select shadow-sm">
                                <option value="">Semua</option>
                                <option value="ya" {{ request('has_keberatan') == 'ya' ? 'selected' : '' }}>Ya</option>
                                <option value="tidak" {{ request('has_keberatan') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            <button class="btn btn-primary btn-rsq px-4" type="submit">
                            <i class="ri-check-line me-1"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>

                    <input type="hidden" name="status" value="{{ request('status') }}">
                    </form>
                </div>
            </div>
        {{-- STATUS PILLS --}}
        @php
            $statuses = [
                'Semua' => ['icon' => 'ri-file-list-3-line', 'label' => 'Semua'],
                'Menunggu Verifikasi' => ['icon' => 'ri-time-line', 'label' => 'Menunggu'],
                'Sedang Diverifikasi' => ['icon' => 'ri-search-eye-line', 'label' => 'Diverifikasi'],
                'Perlu Diperbaiki' => ['icon' => 'ri-error-warning-line', 'label' => 'Perlu Perbaiki'],
                'Menunggu Pembayaran' => ['icon' => 'ri-wallet-3-line', 'label' => 'Menunggu Bayar'],
                'Memverifikasi Pembayaran' => ['icon' => 'ri-secure-payment-line', 'label' => 'Verifikasi Bayar'],
                'Diproses' => ['icon' => 'ri-loader-4-line', 'label' => 'Diproses'],
                'Diterima' => ['icon' => 'ri-checkbox-circle-line', 'label' => 'Diterima'],
                'Ditolak' => ['icon' => 'ri-close-circle-line', 'label' => 'Ditolak'],
            ];
        @endphp

        <div class="mb-4">
            <div class="status-scroll">
                <ul class="nav nav-pills gap-2">
                @foreach($statuses as $key => $meta)
                    @php
                    $isActive = (request('status') == $key || (request('status') == null && $key == 'Semua')) ? 'active' : '';

                    $params = request()->except('page', 'status');
                    if ($key !== 'Semua') $params['status'] = $key;
                    @endphp

                    <li class="nav-item">
                    <a class="nav-link {{ $isActive }} rounded-pill"
                        href="{{ route('admin.permohonan.search', $params) }}">
                        <i class="{{ $meta['icon'] }} me-1"></i> {{ $meta['label'] }}
                    </a>
                    </li>
                @endforeach
                </ul>
            </div>
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
                                {{-- Pembaruan Terakhir --}}
                                <td class="px-4 py-3 align-middle">
                                    <i class="ri-calendar-line text-muted me-2"></i>
                                    {{ $permohonan->updated_at->format('d M Y, H:i') }}
                                </td>
                                
                                {{-- Nama --}}
                                <td class="px-4 py-3 align-middle">
                                    <i class="ri-user-line text-muted me-2"></i>
                                    {{ $permohonan->user->name ?? '-' }}
                                </td>

                                {{-- Jenis Permohonan --}}
                                <td class="px-4 py-3 align-middle">
                                    <span class="fw-medium">{{ ucfirst($permohonan->permohonan_type ?? '-') }}</span>
                                </td>

                                {{-- Status Permohonan --}}
                                <td class="px-4 py-3 align-middle">
                                    <x-badge-status :status="$permohonan->status" />
                                </td>

                                {{-- Status Keberatan --}}
                                <td class="px-4 py-3 align-middle">
                                    @if ($permohonan->keberatan)
                                    @php $status = $permohonan->keberatan->status ?? 'Pending'; @endphp

                                    @switch($status)
                                        @case('Pending')
                                        <span class="badge bg-warning text-dark"><i class="ri-time-line me-1"></i> Pending</span>
                                        @break
                                        @case('Diproses')
                                        <span class="badge bg-info text-dark"><i class="ri-loader-4-line me-1"></i> Diproses</span>
                                        @break
                                        @case('Diterima')
                                        <span class="badge bg-success"><i class="ri-checkbox-circle-line me-1"></i> Diterima</span>
                                        @break
                                        @case('Ditolak')
                                        <span class="badge bg-danger"><i class="ri-close-circle-line me-1"></i> Ditolak</span>
                                        @break
                                        @default
                                        <span class="badge bg-secondary"><i class="ri-question-line me-1"></i> {{ ucfirst($status) }}</span>
                                    @endswitch
                                    @else
                                    <span class="text-muted"><i class="ri-close-circle-line me-1"></i> Tidak Ada</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-3 text-end align-middle">
                                    <a href="{{ route('admin.permohonan.show', $permohonan->id) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="event.stopPropagation();">
                                    Lihat Detail <i class="ri-arrow-right-line ms-1"></i>
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
                            {{-- Header: Status Permohonan + Status Keberatan --}}
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex flex-wrap gap-2">
                                    <x-badge-status :status="$permohonan->status" />

                                    {{-- Status Keberatan (if keberatan exists) --}}
                                    @if($permohonan->keberatan)
                                    @php
                                        $kStatus = $permohonan->keberatan->status ?? 'Pending';
                                    @endphp
                                        @switch($kStatus)
                                            @case('Pending')
                                            <span class="badge bg-warning text-dark small">
                                                <i class="ri-time-line me-1"></i>Keberatan: Pending
                                            </span>
                                            @break

                                            @case('Diproses')
                                            <span class="badge bg-info text-dark small">
                                                <i class="ri-loader-4-line me-1"></i>Keberatan: Diproses
                                            </span>
                                            @break

                                            @case('Diterima')
                                            <span class="badge bg-success small">
                                                <i class="ri-checkbox-circle-line me-1"></i>Keberatan: Diterima
                                            </span>
                                            @break

                                            @case('Ditolak')
                                            <span class="badge bg-danger small">
                                                <i class="ri-close-circle-line me-1"></i>Keberatan: Ditolak
                                            </span>
                                            @break

                                            @default
                                            <span class="badge bg-secondary small">
                                                <i class="ri-question-line me-1"></i>Keberatan: {{ ucfirst($kStatus) }}
                                            </span>
                                        @endswitch
                                    @endif
                                </div>
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
            <div class="card border-0 my-3">
                <div class="card-body py-3">
                    {{ $permohonans->appends(request()->query())->links('vendor.pagination.paginator') }}
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/user-dashboard.css') }}">
    @endpush

    @push('scripts')
    <script>
        (function () {
            const dateFrom = document.getElementById('dateFrom');
            const dateTo   = document.getElementById('dateTo');
            const form     = document.getElementById('filterForm');

            function fmt(d) {
            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
            }

            function startOfWeek(d) {
            const day = (d.getDay() + 6) % 7;
            const out = new Date(d);
            out.setDate(d.getDate() - day);
            return out;
            }

            document.querySelectorAll('.quick-date-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const now = new Date();
                let from = new Date(now);
                let to = new Date(now);

                const type = btn.dataset.type;

                if (type === 'today') {
                } else if (type === 'week') {
                from = startOfWeek(now);
                } else if (type === 'month') {
                from = new Date(now.getFullYear(), now.getMonth(), 1);
                }

                if (dateFrom) dateFrom.value = fmt(from);
                if (dateTo) dateTo.value = fmt(to);

                form.submit();
            });
            });
        })();
    </script>
    @endpush

</x-layout>