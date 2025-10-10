<x-layout>
    <div class="container mt-5 pt-5 pb-5">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <a href="/dashboard" class="text-muted text-decoration-none">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>
                <h3 class="mb-1">Detail Permohonan Informasi</h3>
                <p class="text-muted mb-0">Informasi lengkap tentang permohonan Anda</p>
            </div>
            <div class="d-flex gap-2">
                @can('update', $permohonan)
                    <a href="{{ route('user.permohonan.edit', $permohonan) }}" class="btn btn-warning">
                        <i class="ri-edit-line me-1"></i> Edit
                    </a>
                @endcan
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 d-flex align-items-center" role="alert">
                <i class="ri-checkbox-circle-line me-2" style="font-size: 1.25rem;"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 d-flex align-items-center" role="alert">
                <i class="ri-error-warning-line me-2" style="font-size: 1.25rem;"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Status alerts --}}
        @if($permohonan->status == 'Perlu Diperbaiki')
            <div class="alert alert-warning mb-4 d-flex align-items-start border-0 shadow-sm">
                <i class="ri-error-warning-line me-3 mt-1" style="font-size: 1.5rem;"></i>
                <div>
                    <h6 class="alert-heading mb-2 fw-bold">Permohonan Perlu Diperbaiki</h6>
                    <p class="mb-0">Silakan perbaiki permohonan Anda berdasarkan keterangan petugas di bawah.</p>
                </div>
            </div>
        @elseif($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
            <div class="alert alert-info mb-4 d-flex align-items-start border-0 shadow-sm">
                <i class="ri-information-line me-3 mt-1" style="font-size: 1.5rem;"></i>
                <div>
                    <h6 class="alert-heading mb-2 fw-bold">Status Menunggu Verifikasi</h6>
                    <p class="mb-0">Permohonan Anda masih dapat diedit sebelum diverifikasi oleh petugas.</p>
                </div>
            </div>
        @elseif($permohonan->status == 'Selesai')
            <div class="alert alert-success mb-4 d-flex align-items-start border-0 shadow-sm">
                <i class="ri-checkbox-circle-line me-3 mt-1" style="font-size: 1.5rem;"></i>
                <div>
                    <h6 class="alert-heading mb-2 fw-bold">Permohonan Selesai</h6>
                    <p class="mb-0">Permohonan Anda telah selesai diproses. File balasan tersedia untuk diunduh.</p>
                </div>
            </div>
        @endif

        <!-- Main Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <!-- Status Banner -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between p-3 rounded" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <h5 class="mb-1 fw-bold">{{ ucfirst($permohonan->permohonan_type) }}</h5>
                                    <div class="text-muted small">
                                        <i class="ri-calendar-line me-1"></i>
                                        Dibuat {{ $permohonan->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div>
                                @switch($permohonan->status)
                                    @case('Menunggu Verifikasi Berkas Dari Petugas')
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            <i class="ri-time-line me-1"></i>Menunggu Verifikasi
                                        </span>
                                        @break
                                    @case('Sedang Diverifikasi petugas')
                                        <span class="badge bg-primary px-3 py-2">
                                            <i class="ri-search-eye-line me-1"></i>Diverifikasi
                                        </span>
                                        @break
                                    @case('Perlu Diperbaiki')
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="ri-error-warning-line me-1"></i>Perlu Diperbaiki
                                        </span>
                                        @break
                                    @case('Permohonan Sedang Diproses')
                                        <span class="badge bg-info text-dark px-3 py-2">
                                            <i class="ri-loader-4-line me-1"></i>Diproses
                                        </span>
                                        @break
                                    @case('Selesai')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="ri-checkbox-circle-line me-1"></i>Selesai
                                        </span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary px-3 py-2">
                                            {{ ucfirst($permohonan->status) }}
                                        </span>
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <i class="ri-time-line text-muted me-2 mt-1"></i>
                            <div>
                                <div class="text-muted small mb-1">Waktu Update</div>
                                <div class="fw-medium">{{ $permohonan->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <i class="ri-mail-line text-muted me-2 mt-1"></i>
                            <div>
                                <div class="text-muted small mb-1">Jenis Balasan</div>
                                <div class="fw-medium">{{ ucfirst($permohonan->reply_type) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Keterangan User --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ri-message-3-line text-primary me-2"></i>
                        <h6 class="mb-0 fw-bold">Keterangan User</h6>
                    </div>
                    <div class="p-3 rounded bg-light border">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $permohonan->keterangan_user }}</p>
                    </div>
                </div>

                {{-- Keterangan Petugas --}}
                @if($permohonan->keterangan_petugas)
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-admin-line text-info me-2"></i>
                            <h6 class="mb-0 fw-bold">Keterangan Petugas</h6>
                        </div>
                        <div class="p-3 rounded border" style="background-color: #e7f3ff;">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $permohonan->keterangan_petugas }}</p>
                        </div>
                    </div>
                @endif

                <hr class="my-4">

                <!-- Files Section -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 border">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="ri-file-text-line text-primary me-2" style="font-size: 1.25rem;"></i>
                                    <h6 class="mb-0 fw-bold">File Permohonan</h6>
                                </div>
                                @if($permohonan->permohonan_file)
                                    <a href="{{ Storage::url($permohonan->permohonan_file) }}" 
                                       class="btn btn-outline-primary w-100" 
                                       target="_blank">
                                        <i class="ri-download-line me-1"></i> Download File Permohonan
                                    </a>
                                @else
                                    <div class="text-center py-3 text-muted">
                                        <i class="ri-file-forbid-line" style="font-size: 2rem; opacity: 0.3;"></i>
                                        <p class="small mb-0 mt-2">Tidak ada file</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100 border">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="ri-file-check-line text-success me-2" style="font-size: 1.25rem;"></i>
                                    <h6 class="mb-0 fw-bold">File Balasan</h6>
                                </div>
                                @if($permohonan->reply_file)
                                    <a href="{{ Storage::url($permohonan->reply_file) }}" 
                                       class="btn btn-outline-success w-100" 
                                       target="_blank">
                                        <i class="ri-download-line me-1"></i> Download File Balasan
                                    </a>
                                @else
                                    <div class="text-center py-3 text-muted">
                                        <i class="ri-file-forbid-line" style="font-size: 2rem; opacity: 0.3;"></i>
                                        <p class="small mb-0 mt-2">Belum tersedia</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keberatan Section -->
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <i class="ri-alert-line text-danger me-2" style="font-size: 1.4rem;"></i>
                    <h5 class="mb-0 fw-bold">Keberatan</h5>
                </div>

                @if($permohonan->keberatan)
                    <div class="border rounded p-4 bg-light mb-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <i class="ri-calendar-event-line text-muted me-2"></i>
                                <span class="text-muted small">
                                    Diajukan pada {{ $permohonan->keberatan->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>

                            {{--Status Badge --}}
                            @php
                                $status = $permohonan->keberatan->status;
                                $badgeClass = match($status) {
                                    'Pending' => 'bg-warning text-dark',
                                    'Selesai' => 'bg-success',
                                    default    => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} px-3 py-2">{{ ucfirst($status) }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="fw-semibold text-muted small mb-2">Keterangan Pengguna</div>
                            <div class="p-3 bg-white rounded border">
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $permohonan->keberatan->keterangan_user }}</p>
                            </div>
                        </div>

                        @if($permohonan->keberatan->keberatan_file)
                            <div class="pt-2">
                                <a href="{{ Storage::url($permohonan->keberatan->keberatan_file) }}" 
                                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center"
                                target="_blank">
                                    <i class="ri-download-line me-1"></i> Download File Keberatan
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    @if(in_array($permohonan->status, ['Perlu Diperbaiki', 'Selesai']))
                        <div class="alert alert-info border-0 d-flex flex-wrap align-items-center justify-content-between py-3 px-4 mb-0">
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <i class="ri-information-line me-3" style="font-size: 1.6rem;"></i>
                                <div>
                                    <div class="fw-semibold mb-1">Anda dapat mengajukan keberatan</div>
                                    <div class="small text-muted">Jika Anda tidak puas dengan hasil permohonan, silakan ajukan keberatan.</div>
                                </div>
                            </div>
                            <a href="{{ route('user.keberatan.create', $permohonan->id) }}" 
                            class="btn btn-danger ms-md-3 mt-2 mt-md-0">
                                <i class="ri-add-line me-1"></i> Buat Keberatan
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ri-information-line text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="text-muted mt-3 mb-0">Keberatan tidak tersedia pada status ini</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/permohonan-show.css') }}">
    @endpush

</x-layout>