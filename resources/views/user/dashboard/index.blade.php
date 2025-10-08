<x-layout>
    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Daftar Permohonan Informasi</h3>
                <p class="text-muted mb-0">Kelola dan pantau status pengajuan Anda</p>
            </div>
            <a href="{{ route('user.permohonan.create') }}" class="btn btn-primary">
                <i class="ri-add-line me-1"></i>Tambah Pengajuan
            </a>
        </div>

        {{-- QUICK FILTERS --}}
<div class="mb-4">
    <ul class="nav nav-pills">
        @php
            $statuses = [
                'Semua',
                'Menunggu Verifikasi Berkas Dari Petugas',
                'Sedang Diverifikasi petugas',
                'Perlu Diperbaiki',
                'Diproses',
                'Selesai'
            ];
        @endphp

        @foreach($statuses as $item)
            @php
                // determine if this filter is active
                $active = (request('status') == $item || (request('status') == null && $item == 'Semua')) ? 'active' : '';
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ $active }}" 
                   href="{{ route('user.dashboard.index', ['status' => $item == 'Semua' ? null : $item]) }}">
                    @switch($item)
                        @case('Semua')
                            <i class="ri-file-list-3-line me-1"></i>Semua
                            @break
                        @case('Menunggu Verifikasi Berkas Dari Petugas')
                            <i class="ri-time-line me-1"></i>Menunggu Verifikasi
                            @break
                        @case('Sedang Diverifikasi petugas')
                            <i class="ri-search-eye-line me-1"></i>Diverifikasi
                            @break
                        @case('Perlu Diperbaiki')
                            <i class="ri-error-warning-line me-1"></i>Perlu Diperbaiki
                            @break
                        @case('Diproses')
                            <i class="ri-loader-4-line me-1"></i>Diproses
                            @break
                        @case('Selesai')
                            <i class="ri-checkbox-circle-line me-1"></i>Selesai
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
            <div class="card border-0 shadow-sm">
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
                                                <i class="ri-search-eye-line me-1"></i>Diverifikasi
                                            </span>
                                        @elseif($permohonan->status == 'Perlu Diperbaiki')
                                            <span class="badge bg-danger">
                                                <i class="ri-error-warning-line me-1"></i>Perlu Diperbaiki
                                            </span>
                                        @elseif($permohonan->status == 'Diproses')
                                            <span class="badge bg-info text-dark">
                                                <i class="ri-loader-4-line me-1"></i>Diproses
                                            </span>
                                        @elseif($permohonan->status == 'Selesai')
                                            <span class="badge bg-success">
                                                <i class="ri-checkbox-circle-line me-1"></i>Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="ri-information-line me-1"></i>{{ ucfirst($permohonan->status) }}
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

            <div class="d-flex justify-content-between align-items-center mt-4">
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