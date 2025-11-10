<!-- LEFT: Detail Permohonan -->
<div class="col-lg-7">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <!-- User & Status Banner -->
            <div class="d-flex align-items-center justify-content-between p-3 rounded mb-4" style="background-color: #f8f9fa;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle" style="width: 48px; height: 48px;">
                        <i class="ri-user-line text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ $permohonan->user->name ?? '-' }}</h5>
                        <div class="text-muted small">
                            <i class="ri-mail-line me-1"></i>
                            {{ $permohonan->user->email ?? '-' }}
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

            <!-- Detail Pengajuan -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="ri-booklet-line text-muted me-2 mt-1"></i>
                        <div>
                            <div class="text-muted small mb-1">Jenis Permohonan</div>
                            <div class="fw-medium">{{ ucfirst($permohonan->permohonan_type) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="ri-calendar-line text-muted me-2 mt-1"></i>
                        <div>
                            <div class="text-muted small mb-1">Waktu Dibuat</div>
                            <div class="fw-medium">{{ $permohonan->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="ri-time-line text-muted me-2 mt-1"></i>
                        <div>
                            <div class="text-muted small mb-1">Update Terakhir</div>
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

            {{-- File Permohonan --}}
            <div class="mb-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-file-text-line text-primary me-2"></i>
                    <h6 class="mb-0 fw-bold">File Permohonan</h6>
                </div>
                @if($permohonan->permohonan_file)
                    <a href="{{ Storage::url($permohonan->permohonan_file) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="ri-download-line me-1"></i> Download File Permohonan
                    </a>
                @else
                    <div class="text-center py-3 text-muted border rounded">
                        <i class="ri-file-forbid-line" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="small mb-0 mt-2">Tidak ada file</p>
                    </div>
                @endif
            </div>

            <hr class="my-4">

            {{-- Keberatan Section --}}
            <div>
                <div class="d-flex align-items-center mb-3">
                    <i class="ri-alert-line text-danger me-2"></i>
                    <h6 class="mb-0 fw-bold">Keberatan</h6>
                </div>

                @if($permohonan->keberatan)
                    <div class="border rounded p-3 mb-3" style="background-color: #fff3cd;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ri-calendar-event-line text-muted me-2"></i>
                                <span class="text-muted small">
                                    Diajukan pada {{ $permohonan->keberatan->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                            <span class="badge bg-danger">Keberatan Aktif</span>
                        </div>

                        <div class="mb-3">
                            <div class="fw-bold mb-2 small text-muted">Keterangan Keberatan:</div>
                            <div class="p-3 bg-white rounded border">
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $permohonan->keberatan->keterangan_user }}</p>
                            </div>
                        </div>

                        @if($permohonan->keberatan->keberatan_file)
                            <a href="{{ Storage::url($permohonan->keberatan->keberatan_file) }}" class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="ri-download-line me-1"></i> Download File Keberatan
                            </a>
                        @endif
                    </div>
                @else
                    <div class="text-center py-3 text-muted border rounded">
                        <i class="ri-information-line" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="small mb-0 mt-2">Tidak ada keberatan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
