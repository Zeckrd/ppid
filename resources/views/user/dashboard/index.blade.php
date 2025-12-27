<x-layout>
    <div class="container mt-5 pt-5">
        <div class="row g-3 align-items-center mb-4">
            <div class="col">
            <h3 class="mb-1">Daftar Permohonan Informasi</h3>
            <p class="text-muted mb-0">Kelola dan pantau status pengajuan Anda</p>
            </div>

            <div class="col-12 col-md-auto">
            <a href="{{ route('user.permohonan.create') }}" class="btn btn-primary w-100">
                <i class="ri-add-line me-1"></i>Tambah Pengajuan
            </a>
            </div>
        </div>

        {{-- QUICK FILTERS --}}
        <div class="mb-4">
            <ul class="nav nav-pills flex-wrap gap-2">
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
                        // determine if this filter is active
                        $active = (request('status') == $item || (request('status') == null && $item == 'Semua')) ? 'active' : '';
                    @endphp
                    <li class="nav-item mb-2 me-2">
                        <a class="nav-link {{ $active }}" 
                        href="{{ route('user.dashboard.index', ['status' => $item == 'Semua' ? null : $item]) }}">
                            @switch($item)
                                @case('Semua')
                                    <i class="ri-file-list-3-line me-1"></i>Semua
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

        {{-- CHECK IF PERMOHONAN IS EMPTY RETURN ALERT INSTEAD --}}
        @if($permohonans->isEmpty())
            <div class="text-center py-5 my-5">
                <div class="mb-4">
                    <i class="ri-file-list-3-line" style="font-size: 4rem; color: #6c757d; opacity: 0.5;"></i>
                </div>
                <h5 class="mb-3">Belum Ada Permohonan</h5>
                <p class="text-muted mb-4">Anda belum membuat permohonan apapun.<br>Mulai dengan mengajukan permohonan baru.</p>
                <a href="{{ route('user.permohonan.create') }}" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i>Buat Permohonan Pertama
                </a>
            </div>
        @else
            <div class="card border-0 shadow-sm d-none d-lg-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3 border-0">
                                    <div class="d-flex align-items-center">
                                        Waktu Dibuat
                                        <i class="ms-2 text-muted" style="font-size: 0.875rem;"></i>
                                    </div>
                                </th>
                                <th class="px-4 py-3 border-0">
                                    <div class="d-flex align-items-center">
                                        Jenis Permohonan
                                        <i class="ms-2 text-muted" style="font-size: 0.875rem;"></i>
                                    </div>
                                </th>
                                <th class="px-4 py-3 border-0">Status</th>
                                <th class="px-4 py-3 border-0">Ajuan Keberatan</th>
                                <th class="px-4 py-3 border-0 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permohonans as $index => $permohonan)
                                <tr class="cursor-pointer" onclick="window.location='{{ route('user.permohonan.show', $permohonan->id) }}';" style="cursor: pointer;">
                                    <td class="px-4 py-3 align-middle">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-calendar-line text-muted me-2"></i>
                                            <span>{{ $permohonan->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium">{{ ucfirst($permohonan->permohonan_type) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        @if($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
                                            <span class="badge bg-warning text-dark">
                                                <i class="ri-time-line me-1"></i>Menunggu Verifikasi
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
                                            <span class="badge bg-success small">
                                                <i class="ri-checkbox-circle-line me-1"></i> Diterima
                                            </span>
                                        @elseif($permohonan->status == 'Ditolak')
                                            <span class="badge bg-danger small">
                                                <i class="ri-close-circle-line me-1"></i> Ditolak
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
                                                <i class="ri-close-circle-line me-1"></i> Ditolak
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

                                    <td class="px-4 py-3 align-middle text-end">
                                        <a href="{{ route('user.permohonan.show', $permohonan->id) }}" 
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
            <div class="d-lg-none mt-3">
                @foreach($permohonans as $permohonan)
                    <div class="card border-0 shadow-sm mb-3"
                        onclick="window.location='{{ route('user.permohonan.show', $permohonan->id) }}';"
                        style="cursor: pointer;">
                        <div class="card-body p-3">
                            {{-- Header: Status Permohonan + Status Keberatan --}}
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex flex-wrap gap-2">

                                    {{-- Status Permohonan --}}
                                    @if($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
                                    <span class="badge bg-warning text-dark small">
                                        <i class="ri-time-line me-1"></i>Menunggu Verifikasi
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
                                        <i class="ri-close-circle-line me-1"></i>Ditolak
                                    </span>
                                    @else
                                    <span class="badge bg-secondary small">{{ ucfirst($permohonan->status) }}</span>
                                    @endif

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

                            {{-- Jenis Permohonan --}}
                            <h6 class="mb-2 fw-semibold">
                                <i class="ri-file-text-line text-muted me-1"></i>
                                {{ ucfirst($permohonan->permohonan_type ?? '-') }}
                            </h6>

                            {{-- Info Row --}}
                            <div class="row g-2 small text-muted mb-3">
                                <div class="col-6">
                                    <i class="ri-calendar-line me-1"></i>
                                    {{ $permohonan->created_at->format('d M Y') }}
                                </div>
                            </div>

                            {{-- Action --}}
                            <a href="{{ route('user.permohonan.show', $permohonan->id) }}"
                            class="btn btn-outline-primary btn-sm w-100"
                            onclick="event.stopPropagation();">
                                Lihat Detail <i class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <div class="text-muted">
                <i class="ri-file-list-line me-1"></i>
                Menampilkan <strong>{{ $permohonans->firstItem() }}</strong> 
                sampai <strong>{{ $permohonans->lastItem() }}</strong> 
                dari <strong>{{ $permohonans->total() }}</strong> pengajuan
            </div>
                <div>
                    {{ $permohonans->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/user-dashboard.css') }}">
    @endpush

</x-layout>