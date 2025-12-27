<x-layout>
    <div class="container mt-5 pt-5 pb-5">
    <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3 mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <a href="/dashboard" class="text-muted text-decoration-none">
                    <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>
                <h3 class="mb-1">Detail Permohonan Informasi</h3>
                <p class="text-muted mb-0">Informasi lengkap tentang permohonan Anda</p>
            </div>

            <div class="col-12 col-md-auto">
                @can('update', $permohonan)
                    <a href="{{ route('user.permohonan.edit', $permohonan) }}"
                    class="btn btn-warning w-100 w-lg-auto">
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
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2 p-3 rounded"
                            style="background-color: #f8f9fa;">
                            
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <h5 class="mb-1 fw-bold">{{ ucfirst($permohonan->permohonan_type) }}</h5>
                                <div class="text-muted small text-nowrap">
                                    <i class="ri-calendar-line me-1"></i>Dibuat {{ $permohonan->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="w-100 w-md-auto text-md-end">
                            @switch($permohonan->status)
                            @case('Menunggu Verifikasi Berkas Dari Petugas')
                                <span class="badge bg-warning text-dark px-3 py-2 d-inline-flex align-items-center">
                                <i class="ri-time-line me-1"></i> Menunggu Verifikasi
                                </span>
                                @break
                            @case('Sedang Diverifikasi petugas')
                                <span class="badge bg-primary px-3 py-2 d-inline-flex align-items-center">
                                <i class="ri-search-eye-line me-1"></i> Diverifikasi
                                </span>
                                @break
                            @case('Perlu Diperbaiki')
                                <span class="badge bg-danger px-3 py-2 d-inline-flex align-items-center">
                                <i class="ri-error-warning-line me-1"></i> Perlu Diperbaiki
                                </span>
                                @break
                            @case('Diproses')
                                <span class="badge bg-info text-dark px-3 py-2 d-inline-flex align-items-center">
                                <i class="ri-loader-4-line me-1"></i> Diproses
                                </span>
                                @break
                            @case('Diterima')
                                <span class="badge bg-success px-3 py-2 d-inline-flex align-items-center">
                                <i class="ri-checkbox-circle-line me-1"></i> Diterima
                                </span>
                                @break
                            @case('Ditolak')
                                <span class="badge bg-danger px-3 py-2 d-inline-flex align-items-center">
                                <i class="ri-close-circle-line me-1"></i> Ditolak
                                </span>
                                @break
                            @default
                                <span class="badge bg-secondary px-3 py-2 d-inline-flex align-items-center">
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

                {{-- File Permohonan --}}
                <div class="row g-4 mb-4">
                    {{-- File Permohonan (User upload) --}}
                    <div class="col-md-6">
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ri-file-text-line text-primary me-2"></i>
                                <h6 class="mb-0 fw-bold">File Permohonan</h6>
                            </div>
                            @if($permohonan->files->count())
                                <ul class="list-group mb-3">
                                    @foreach($permohonan->files as $file)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                <div class="flex-grow-1 min-width-0">
                                                    <div class="fw-medium text-truncate" title="{{ $file->original_name }}">
                                                        <i class="ri-file-line me-1"></i>
                                                        {{ $file->original_name }}
                                                    </div>
                                                    @if($file->size)
                                                        <div class="small text-muted">
                                                            {{ number_format($file->size / 1024, 1) }} KB
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                                    {{-- Lihat (PDF only) --}}
                                                    @if($file->isPdf())
                                                        <a href="{{ route('user.permohonan.files.view', [$permohonan->id, $file->id]) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-secondary text-nowrap"
                                                        title="Lihat (buka di tab baru)">
                                                            <i class="ri-eye-line"></i> Lihat
                                                        </a>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-secondary opacity-50 text-nowrap"
                                                                title="Hanya dapat dilihat untuk file PDF"
                                                                aria-disabled="true">
                                                            <i class="ri-eye-off-line"></i> Lihat
                                                        </button>
                                                    @endif

                                                    {{-- Download (all types) --}}
                                                    <a href="{{ route('user.permohonan.files.download', [$permohonan->id, $file->id]) }}"
                                                    class="btn btn-sm btn-outline-primary text-nowrap"
                                                    target="_blank"
                                                    title="Download">
                                                        <i class="ri-download-line me-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-3 text-muted border rounded">
                                    <i class="ri-file-forbid-line" style="font-size: 2rem; opacity: 0.3;"></i>
                                    <p class="small mb-0 mt-2">Tidak ada file</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- File Balasan dari Admin --}}
                    <div class="col-md-6">
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ri-mail-check-line text-success me-2"></i>
                                <h6 class="mb-0 fw-bold">File Balasan</h6>
                            </div>
                            @if($permohonan->replyFiles->count())
                                <ul class="list-group mb-3">
                                    @foreach($permohonan->replyFiles as $file)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                <div class="flex-grow-1 min-width-0">
                                                    <div class="fw-medium text-truncate" title="{{ $file->original_name }}">
                                                        <i class="ri-file-line me-1"></i>
                                                        {{ $file->original_name }}
                                                    </div>
                                                    @if($file->size)
                                                        <div class="small text-muted">
                                                            {{ number_format($file->size / 1024, 1) }} KB
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                                    {{-- Lihat (PDF only) --}}
                                                    @if($file->isPdf())
                                                        <a href="{{ route('user.permohonan.reply-files.view', [$permohonan->id, $file->id]) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-secondary text-nowrap"
                                                        title="Lihat (buka di tab baru)">
                                                            <i class="ri-eye-line"></i> Lihat
                                                        </a>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-secondary opacity-50 text-nowrap"
                                                                title="Hanya dapat dilihat untuk file PDF"
                                                                aria-disabled="true">
                                                            <i class="ri-eye-off-line"></i> Lihat
                                                        </button>
                                                    @endif

                                                    {{-- Download (all types) --}}
                                                    <a href="{{ route('user.permohonan.reply-files.download', [$permohonan->id, $file->id]) }}"
                                                    class="btn btn-sm btn-outline-success text-nowrap"
                                                    target="_blank"
                                                    title="Download">
                                                        <i class="ri-download-line me-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-3 text-muted border rounded">
                                    <i class="ri-information-line" style="font-size: 2rem; opacity: 0.3;"></i>
                                    <p class="small mb-0 mt-2">Belum ada file balasan dari admin.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keberatan Section -->
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-body p-4">

                <!-- Section Title -->
                <div class="d-flex align-items-center mb-4">
                    <i class="ri-alert-line text-danger me-2" style="font-size: 1.4rem;"></i>
                    <h5 class="mb-0 fw-bold">Keberatan</h5>
                </div>

                @if($permohonan->keberatan)

                @php
                    $k = $permohonan->keberatan;
                    $status = $k->status ?? 'Pending';

                    $badgeClass = match($status) {
                    'Pending'  => 'bg-warning text-dark',
                    'Diproses' => 'bg-info text-dark',
                    'Diterima' => 'bg-success',
                    'Ditolak'  => 'bg-danger',
                    default    => 'bg-secondary',
                    };
                @endphp

                <!-- Banner -->
                <div class="mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2 p-3 rounded"
                        style="background-color: #f8f9fa;">
                    <div>
                        <div class="text-muted small text-nowrap">
                        <i class="ri-calendar-event-line me-1"></i>
                        Diajukan {{ $k->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <!-- Badge -->
                    <div class="w-100 text-md-end">
                        <span class="badge {{ $badgeClass }} px-3 py-2 d-inline-flex align-items-center">
                        <i class="ri-shield-check-line me-1"></i> {{ ucfirst($status) }}
                        </span>
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
                        <div class="fw-medium">{{ $k->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    </div>
                    <!-- write sometin here i guess -->
                </div>

                <hr class="my-4">

                {{-- Keterangan User --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                    <i class="ri-message-3-line text-primary me-2"></i>
                    <h6 class="mb-0 fw-bold">Keterangan User</h6>
                    </div>
                    <div class="p-3 rounded bg-light border">
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $k->keterangan_user }}</p>
                    </div>
                </div>

                {{-- Keterangan Petugas --}}
                @if($k->keterangan_petugas)
                    <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ri-admin-line text-info me-2"></i>
                        <h6 class="mb-0 fw-bold">Keterangan Petugas</h6>
                    </div>
                    <div class="p-3 rounded border" style="background-color: #e7f3ff;">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $k->keterangan_petugas }}</p>
                    </div>
                    </div>
                @endif

                <hr class="my-4">

                <!-- Files Section -->
                <div class="row g-4 mb-0">

                    {{-- File Keberatan (user upload) --}}
                    <div class="col-md-6">
                    <div class="mb-4 mb-md-0">
                        <div class="d-flex align-items-center mb-3">
                        <i class="ri-file-text-line text-primary me-2"></i>
                        <h6 class="mb-0 fw-bold">File Keberatan</h6>
                        </div>

                        @if($k->files->count())
                        <ul class="list-group mb-0">
                            @foreach($k->files as $file)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-medium text-truncate" title="{{ $file->original_name }}">
                                    <i class="ri-file-line me-1"></i>
                                    {{ $file->original_name }}
                                    </div>
                                    @if($file->size)
                                    <div class="small text-muted">
                                        {{ number_format($file->size / 1024, 1) }} KB
                                    </div>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    @if($file->isPdf())
                                    <a href="{{ route('user.keberatan.files.view', [$permohonan, $k, $file]) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-secondary text-nowrap"
                                        title="Lihat (buka di tab baru)">
                                        <i class="ri-eye-line"></i> Lihat
                                    </a>
                                    @else
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary opacity-50 text-nowrap"
                                            title="Hanya dapat dilihat untuk file PDF"
                                            aria-disabled="true">
                                        <i class="ri-eye-off-line"></i> Lihat
                                    </button>
                                    @endif

                                    <a href="{{ route('user.keberatan.files.download', [$permohonan, $k, $file]) }}"
                                    class="btn btn-sm btn-outline-primary text-nowrap"
                                    target="_blank"
                                    title="Download">
                                    <i class="ri-download-line me-1"></i> Download
                                    </a>
                                </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="text-center py-3 text-muted border rounded bg-light">
                            <i class="ri-file-forbid-line" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="small mb-0 mt-2">Belum ada file keberatan diunggah</p>
                        </div>
                        @endif
                    </div>
                    </div>

                    {{-- File Balasan Keberatan (admin reply) --}}
                    <div class="col-md-6">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                        <i class="ri-mail-check-line text-success me-2"></i>
                        <h6 class="mb-0 fw-bold">File Balasan Keberatan</h6>
                        </div>

                        @if($k->replyFiles->count())
                        <ul class="list-group mb-0">
                            @foreach($k->replyFiles as $file)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                <div class="flex-grow-1 min-width-0">
                                    <div class="fw-medium text-truncate" title="{{ $file->original_name }}">
                                    <i class="ri-file-line me-1"></i>
                                    {{ $file->original_name }}
                                    </div>
                                    @if($file->size)
                                    <div class="small text-muted">
                                        {{ number_format($file->size / 1024, 1) }} KB
                                    </div>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                    @if($file->isPdf())
                                    <a href="{{ route('user.keberatan.reply_files.view', [$permohonan, $k, $file]) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-secondary text-nowrap"
                                        title="Lihat (buka di tab baru)">
                                        <i class="ri-eye-line"></i> Lihat
                                    </a>
                                    @else
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary opacity-50 text-nowrap"
                                            title="Hanya dapat dilihat untuk file PDF"
                                            aria-disabled="true">
                                        <i class="ri-eye-off-line"></i> Lihat
                                    </button>
                                    @endif

                                    <a href="{{ route('user.keberatan.reply_files.download', [$permohonan, $k, $file]) }}"
                                    class="btn btn-sm btn-outline-success text-nowrap"
                                    target="_blank"
                                    title="Download">
                                    <i class="ri-download-line me-1"></i> Download
                                    </a>
                                </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="text-center py-3 text-muted border rounded bg-light">
                            <i class="ri-information-line" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="small mb-0 mt-2">Belum ada file balasan keberatan.</p>
                        </div>
                        @endif
                    </div>
                    </div>

                </div>

                @else
                {{-- empty / CTA state  --}}
                @if(in_array($permohonan->status, ['Perlu Diperbaiki', 'Diterima', 'Ditolak']))
                    <div class="p-3 p-md-4 rounded border" style="background-color: #f8f9fa;">
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                        <div class="d-flex align-items-start gap-3">
                        <i class="ri-information-line text-info" style="font-size: 1.8rem;"></i>
                        <div>
                            <div class="fw-semibold mb-1">Anda dapat mengajukan keberatan</div>
                            <div class="small text-muted">
                            Jika Anda tidak puas dengan hasil permohonan, silakan ajukan keberatan.
                            </div>
                        </div>
                        </div>

                        <a href="{{ route('user.keberatan.create', $permohonan->id) }}"
                        class="btn btn-danger w-100 w-md-auto">
                        <i class="ri-add-line me-1"></i> Buat Keberatan
                        </a>
                    </div>
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


    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/permohonan-show.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/permohonan-files.js') }}"></script>
    @endpush
</x-layout>
