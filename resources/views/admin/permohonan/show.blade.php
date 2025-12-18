<x-layout>
    <div class="container mt-5 pt-5 pb-5">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <a href="{{ route('admin.permohonan.search') }}" class="text-muted text-decoration-none">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>
                <h3 class="mb-1">Detail Permohonan #{{ $permohonan->id }}</h3>
                <p class="text-muted mb-0">Kelola dan proses permohonan</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-secondary px-3 py-2">Admin View</span>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 d-flex align-items-center border-0 shadow-sm" role="alert">
                <i class="ri-checkbox-circle-line me-2" style="font-size: 1.25rem;"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 d-flex align-items-center border-0 shadow-sm" role="alert">
                <i class="ri-error-warning-line me-2" style="font-size: 1.25rem;"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- LEFT: Permohonan Info + Keberatan Summary -->
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
                                            <i class="ri-time-line me-1"></i> Menunggu Verifikasi
                                        </span>
                                        @break
                                    @case('Sedang Diverifikasi petugas')
                                        <span class="badge bg-primary px-3 py-2">
                                            <i class="ri-search-eye-line me-1"></i> Diverifikasi
                                        </span>
                                        @break
                                    @case('Perlu Diperbaiki')
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="ri-error-warning-line me-1"></i> Perlu Diperbaiki
                                        </span>
                                        @break
                                    @case('Diproses')
                                        <span class="badge bg-info text-dark px-3 py-2">
                                            <i class="ri-loader-4-line me-1"></i> Diproses
                                        </span>
                                        @break
                                    @case('Diterima')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="ri-checkbox-circle-line me-1"></i> Diterima
                                        </span>
                                        @break
                                    @case('Ditolak')
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="ri-close-circle-line"></i> Ditolak
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
                                <h6 class="mb-0 fw-bold">Lampiran</h6>
                            </div>

                            @if($permohonan->files->count())
                                <ul class="list-group mb-3">
                                    @foreach($permohonan->files as $file)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                <div class="flex-grow-1 min-width-0">
                                                    <div class="fw-medium text-truncate" title="{{ $file->original_name }}">
                                                        {{-- BLUE icon --}}
                                                        <i class="ri-file-line me-1 text-primary"></i>
                                                        {{ $file->original_name }}
                                                    </div>
                                                    @if($file->size)
                                                        <div class="small text-muted">
                                                            {{ number_format($file->size / 1024, 1) }} KB
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                                    {{-- eye icon --}}
                                                    @if ($file->isPdf())
                                                        <a href="{{ route('admin.permohonan.files.view', [$permohonan->id, $file->id]) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        title="Lihat (buka di tab baru)">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-secondary opacity-50"
                                                                title="Hanya dapat dilihat untuk file PDF"
                                                                aria-disabled="true">
                                                            <i class="ri-eye-off-line"></i>
                                                        </button>
                                                    @endif

                                                    <a href="{{ route('admin.permohonan.files.download', [$permohonan->id, $file->id]) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Download">
                                                        <i class="ri-download-line"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('admin.permohonan.files.zip', $permohonan->id) }}"
                                   class="btn btn-outline-primary">
                                    <i class="ri-folder-download-line me-1"></i>
                                    Download Semua Lampiran (ZIP)
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
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ri-alert-line text-danger me-2"></i>
                                <h6 class="mb-0 fw-bold">Keberatan</h6>
                            </div>

                            @if($permohonan->keberatan)
                                <div class="border rounded-3 p-3" style="background-color: #f8f9fa;">
                                    {{-- Meta info --}}
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-calendar-event-line text-muted me-2"></i>
                                            <span class="text-muted small">
                                                Diajukan pada {{ $permohonan->keberatan->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        @php
                                            $kbStatus = $permohonan->keberatan->status ?? 'Pending';
                                        @endphp
                                        @switch($kbStatus)
                                            @case('Pending')
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="ri-time-line me-1"></i> Pending
                                                </span>
                                                @break
                                            @case('Diproses')
                                                <span class="badge bg-info text-dark px-3 py-2">
                                                    <i class="ri-loader-4-line me-1"></i> Diproses
                                                </span>
                                                @break
                                            @case('Diterima')
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="ri-checkbox-circle-line me-1"></i> Diterima
                                                </span>
                                                @break
                                            @case('Ditolak')
                                                <span class="badge bg-danger px-3 py-2">
                                                    <i class="ri-close-circle-line"></i> Ditolak
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary px-3 py-2">
                                                    {{ ucfirst($kbStatus) }}
                                                </span>
                                        @endswitch
                                    </div>

                                    {{-- Keterangan user --}}
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ri-message-3-line text-danger me-2"></i>
                                            <span class="small text-muted fw-bold">Keterangan User</span>
                                        </div>
                                        <div class="p-3 rounded bg-light border">
                                            <p class="mb-0" style="white-space: pre-wrap;">{{ $permohonan->keberatan->keterangan_user }}</p>
                                        </div>
                                    </div>

                                    <hr class="my-3">

                                    {{-- Lampiran Keberatan --}}
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center mb-3">
                                            {{-- RED icon --}}
                                            <i class="ri-file-text-line text-danger me-2"></i>
                                            <h6 class="mb-0 small text-muted fw-bold">Lampiran</h6>
                                        </div>

                                        @if($permohonan->keberatan->files->count())
                                            <ul class="list-group mb-3">
                                                @foreach($permohonan->keberatan->files as $file)
                                                    <li class="list-group-item">
                                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                                            <div class="flex-grow-1 min-width-0">
                                                                <div class="fw-medium text-truncate kb-file-name" title="{{ $file->original_name }}">
                                                                    {{-- RED file icon --}}
                                                                    <i class="ri-file-line me-1 text-danger"></i>
                                                                    {{ $file->original_name }}
                                                                </div>
                                                                @if($file->size)
                                                                    <div class="small text-muted">
                                                                        {{ number_format($file->size / 1024, 1) }} KB
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                                                {{-- eye icon --}}
                                                                @if($file->isPdf())
                                                                    <a href="{{ route('admin.keberatan.files.view', [$permohonan, $permohonan->keberatan, $file]) }}"
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-outline-secondary"
                                                                    title="Lihat (buka di tab baru)">
                                                                        <i class="ri-eye-line"></i>
                                                                    </a>
                                                                @else
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-outline-secondary opacity-50"
                                                                            title="Hanya dapat dilihat untuk file PDF"
                                                                            aria-disabled="true">
                                                                        <i class="ri-eye-off-line"></i>
                                                                    </button>
                                                                @endif

                                                                <a href="{{ route('admin.keberatan.files.download', [$permohonan, $permohonan->keberatan, $file]) }}"
                                                                class="btn btn-sm btn-outline-primary"
                                                                title="Download">
                                                                    <i class="ri-download-line"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="text-center py-3 text-muted border rounded">
                                                <i class="ri-file-forbid-line" style="font-size: 2rem; opacity: 0.3;"></i>
                                                <p class="small mb-0 mt-2">Tidak ada file keberatan</p>
                                            </div>
                                        @endif
                                    </div>
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

            {{-- RIGHT: Single Admin Actions Form --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 position-sticky" style="top: 2rem;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-settings-3-line text-primary me-2" style="font-size: 1.25rem;"></i>
                            <h5 class="mb-0 fw-bold">Aksi Admin</h5>
                        </div>

                        {{-- Single form for Permohonan + Keberatan + Notifikasi --}}
                        <form action="{{ route('admin.permohonan.update', $permohonan->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- SECTION: Permohonan --}}
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge rounded-pill bg-primary text-white d-inline-flex align-items-center gap-1 px-3 py-2">
                                        <i class="ri-file-list-3-line"></i>
                                        <span>Permohonan</span>
                                    </span>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold">
                                        <i class="ri-flag-line me-1 text-primary"></i> Update Status
                                    </label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="Menunggu Verifikasi Berkas Dari Petugas" @selected($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')>Menunggu Verifikasi</option>
                                        <option value="Sedang Diverifikasi petugas" @selected($permohonan->status == 'Sedang Diverifikasi petugas')>Sedang Diverifikasi</option>
                                        <option value="Perlu Diperbaiki" @selected($permohonan->status == 'Perlu Diperbaiki')>Perlu Diperbaiki</option>
                                        <option value="Diproses" @selected($permohonan->status == 'Diproses')>Diproses</option>
                                        <option value="Diterima" @selected($permohonan->status == 'Diterima')>Diterima</option>
                                        <option value="Ditolak" @selected($permohonan->status == 'Ditolak')>Ditolak</option>
                                    </select>
                                </div>

                                <!-- Keterangan Petugas (Permohonan) -->
                                <div class="mb-3">
                                    <label for="keterangan_petugas" class="form-label fw-bold">
                                        <i class="ri-message-2-line me-1 text-primary"></i> Keterangan Petugas
                                    </label>
                                    <textarea name="keterangan_petugas"
                                            id="keterangan_petugas"
                                            rows="4"
                                            class="form-control"
                                            placeholder="Berikan keterangan...">{{ old('keterangan_petugas', $permohonan->keterangan_petugas) }}</textarea>
                                </div>

                                @php
                                    $replyFiles = $permohonan->replyFiles;
                                @endphp

                                <!-- Upload File Balasan (Permohonan) -->
                                <div class="mb-3">
                                    <label for="reply_files" class="form-label fw-bold">
                                        <i class="ri-file-upload-line me-1 text-primary"></i> Upload File Balasan
                                    </label>
                                    <input type="file"
                                        name="reply_files[]"
                                        id="reply_files"
                                        class="form-control
                                            @error('reply_files') is-invalid @enderror
                                            @error('reply_files.*') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx"
                                        multiple>
                                    <x-form-error name="reply_files"></x-form-error>
                                    <x-form-error name="reply_files.*"></x-form-error>
                                    <div id="reply_files_error" class="invalid-feedback"></div>
                                    <div class="form-text small text-muted">
                                        <i class="ri-information-line text-primary"></i>
                                        (PDF, DOC, DOCX). Maksimal 10 file, masing-masing 5 MB.
                                    </div>

                                    {{-- Preview files about to be uploaded --}}
                                    <div id="reply_files_preview" class="mt-2 d-none">
                                        <div class="small text-muted d-flex align-items-start gap-2 flex-wrap">
                                            <span class="mt-1">
                                                <i class="ri-upload-2-line me-1 text-primary"></i>
                                                File yang akan diunggah:
                                            </span>
                                            <div id="reply_files_preview_chips" class="d-flex flex-wrap gap-1"></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Existing reply files --}}
                                @if($replyFiles->count())
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="small text-muted">
                                                <i class="ri-file-check-line me-1 text-primary"></i>
                                                {{ $replyFiles->count() }} file balasan
                                            </span>
                                        </div>

                                        <ul class="list-group list-group-flush rounded border">
                                            @foreach($replyFiles as $file)
                                                @php
                                                    $isMarked = is_array(old('delete_reply_file_ids')) && in_array($file->id, old('delete_reply_file_ids'));
                                                @endphp

                                                <li class="list-group-item reply-file-item {{ $isMarked ? 'reply-file-marked-for-deletion' : '' }}">
                                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                                        <div class="flex-grow-1 min-width-0">
                                                            <div class="fw-medium text-truncate reply-file-name" title="{{ $file->original_name }}">
                                                                {{-- BLUE file icon --}}
                                                                <i class="ri-file-line me-1 text-primary"></i>
                                                                {{ $file->original_name }}
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                @if($file->size)
                                                                    <div class="small text-muted">
                                                                        {{ number_format($file->size / 1024, 1) }} KB
                                                                    </div>
                                                                @endif
                                                                <span class="badge rounded-pill bg-danger-subtle text-danger small delete-badge"
                                                                    style="{{ $isMarked ? '' : 'display:none;' }}">
                                                                    Akan dihapus
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                                            {{-- View --}}
                                                            @if($file->isPdf())
                                                                <a href="{{ route('admin.permohonan.reply-files.view', [$permohonan->id, $file->id]) }}"
                                                                target="_blank"
                                                                class="btn btn-sm btn-outline-secondary"
                                                                title="Lihat (buka di tab baru)">
                                                                    <i class="ri-eye-line"></i>
                                                                </a>
                                                            @else
                                                                <button type="button"
                                                                        class="btn btn-sm btn-outline-secondary opacity-50"
                                                                        title="Hanya dapat dilihat untuk file PDF"
                                                                        aria-disabled="true">
                                                                    <i class="ri-eye-off-line"></i>
                                                                </button>
                                                            @endif

                                                            {{-- Download --}}
                                                            <a href="{{ route('admin.permohonan.reply-files.download', [$permohonan->id, $file->id]) }}"
                                                            class="btn btn-sm btn-outline-primary"
                                                            title="Download">
                                                                <i class="ri-download-line"></i>
                                                            </a>

                                                            {{-- Delete toggle --}}
                                                            <button type="button"
                                                                    class="btn btn-sm btn-outline-danger reply-file-delete-toggle"
                                                                    data-file-id="{{ $file->id }}"
                                                                    title="{{ $isMarked ? 'Batal tandai hapus' : 'Tandai untuk dihapus' }}">
                                                                <i class="{{ $isMarked ? 'ri-delete-bin-fill' : 'ri-delete-bin-line' }}"></i>
                                                            </button>

                                                            <input type="checkbox"
                                                                name="delete_reply_file_ids[]"
                                                                value="{{ $file->id }}"
                                                                id="delete_reply_file_{{ $file->id }}"
                                                                class="reply-file-delete-checkbox d-none"
                                                                {{ $isMarked ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </div>

                            {{-- SECTION: Keberatan (only if exists) --}}
                            @if($permohonan->keberatan)
                                <div class="mb-4 border-top pt-3">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <span class="badge rounded-pill bg-danger text-white d-inline-flex align-items-center gap-1 px-3 py-2">
                                            <i class="ri-alert-line"></i>
                                            <span>Keberatan</span>
                                        </span>
                                    </div>

                                    <!-- Status Keberatan -->
                                    <div class="mb-3">
                                        <label for="keberatan_status" class="form-label fw-bold">
                                            <i class="ri-flag-2-line me-1 text-danger"></i> Update Status
                                        </label>
                                        <select name="keberatan_status" id="keberatan_status" class="form-select">
                                            <option value="Pending"  @selected($permohonan->keberatan->status == 'Pending')>Pending</option>
                                            <option value="Diproses" @selected($permohonan->keberatan->status == 'Diproses')>Diproses</option>
                                            <option value="Diterima" @selected($permohonan->keberatan->status == 'Diterima')>Diterima</option>
                                            <option value="Ditolak"  @selected($permohonan->keberatan->status == 'Ditolak')>Ditolak</option>
                                        </select>
                                    </div>

                                    <!-- Keterangan Petugas (Keberatan) -->
                                    <div class="mb-3">
                                        <label for="keberatan_keterangan_petugas" class="form-label fw-bold">
                                            <i class="ri-message-2-line me-1 text-danger"></i> Keterangan Petugas
                                        </label>
                                        <textarea name="keberatan_keterangan_petugas"
                                                id="keberatan_keterangan_petugas"
                                                rows="4"
                                                class="form-control"
                                                placeholder="Masukkan keterangan petugas...">{{ old('keberatan_keterangan_petugas', $permohonan->keberatan->keterangan_petugas) }}</textarea>
                                    </div>

                                    @php
                                        $kbReplyFiles = $permohonan->keberatan->replyFiles;
                                    @endphp

                                    <!-- Upload File Balasan Keberatan -->
                                    <div class="mb-3">
                                        <label for="keberatan_reply_files" class="form-label fw-bold">
                                            <i class="ri-file-upload-line me-1 text-danger"></i> Upload File Balasan
                                        </label>
                                        <input type="file"
                                            name="keberatan_reply_files[]"
                                            id="keberatan_reply_files"
                                            class="form-control
                                                @error('keberatan_reply_files') is-invalid @enderror
                                                @error('keberatan_reply_files.*') is-invalid @enderror"
                                            accept=".pdf,.doc,.docx"
                                            multiple>
                                        <x-form-error name="keberatan_reply_files"></x-form-error>
                                        <x-form-error name="keberatan_reply_files.*"></x-form-error>
                                        <div id="keberatan_reply_files_error" class="invalid-feedback d-none"></div>
                                        <div class="form-text small text-muted">
                                            <i class="ri-information-line text-danger"></i>
                                            (PDF, DOC, DOCX). Maksimal 10 file, masing-masing 5 MB.
                                        </div>

                                        {{-- Preview files to be uploaded --}}
                                        <div id="keberatan_reply_files_preview" class="mt-2 d-none">
                                            <div class="small text-muted d-flex align-items-start gap-2 flex-wrap">
                                                <span class="mt-1">
                                                    <i class="ri-upload-2-line me-1 text-danger"></i>
                                                    File yang akan diunggah:
                                                </span>
                                                <div id="keberatan_reply_files_preview_chips"
                                                    class="d-flex flex-wrap gap-1"></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Existing reply files --}}
                                    @if($kbReplyFiles->count())
                                        <div class="mt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="small text-muted">
                                                    <i class="ri-file-check-line me-1 text-danger"></i>
                                                    {{ $kbReplyFiles->count() }} file balasan keberatan
                                                </span>
                                            </div>

                                            <ul class="list-group list-group-flush rounded border">
                                                @foreach($kbReplyFiles as $file)
                                                    @php
                                                        $kbMarked = is_array(old('delete_keberatan_reply_file_ids'))
                                                            && in_array($file->id, old('delete_keberatan_reply_file_ids'));
                                                    @endphp

                                                    <li class="list-group-item kb-reply-file-item {{ $kbMarked ? 'kb-reply-file-marked-for-deletion' : '' }}">
                                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                                            <div class="flex-grow-1 min-width-0">
                                                                <div class="fw-medium text-truncate kb-reply-file-name" title="{{ $file->original_name }}">
                                                                    {{-- RED file icon --}}
                                                                    <i class="ri-file-line me-1 text-danger"></i>
                                                                    {{ $file->original_name }}
                                                                </div>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    @if($file->size)
                                                                        <div class="small text-muted">
                                                                            {{ number_format($file->size / 1024, 1) }} KB
                                                                        </div>
                                                                    @endif
                                                                    <span class="badge rounded-pill bg-danger-subtle text-danger small kb-delete-badge"
                                                                        style="{{ $kbMarked ? '' : 'display:none;' }}">
                                                                        Akan dihapus
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                                                {{-- View --}}
                                                                @if($file->isPdf())
                                                                    <a href="{{ route('admin.keberatan.reply_files.view', [$permohonan, $permohonan->keberatan, $file]) }}"
                                                                    target="_blank"
                                                                    class="btn btn-sm btn-outline-secondary"
                                                                    title="Lihat (buka di tab baru)">
                                                                        <i class="ri-eye-line"></i>
                                                                    </a>
                                                                @else
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-outline-secondary opacity-50"
                                                                            title="Hanya dapat dilihat untuk file PDF"
                                                                            aria-disabled="true">
                                                                        <i class="ri-eye-off-line"></i>
                                                                    </button>
                                                                @endif

                                                                {{-- Download --}}
                                                                <a href="{{ route('admin.keberatan.reply_files.download', [$permohonan, $permohonan->keberatan, $file]) }}"
                                                                class="btn btn-sm btn-outline-primary"
                                                                title="Download">
                                                                    <i class="ri-download-line"></i>
                                                                </a>

                                                                {{-- Trash toggle --}}
                                                                <button type="button"
                                                                        class="btn btn-sm btn-outline-danger kb-reply-file-delete-toggle"
                                                                        title="{{ $kbMarked ? 'Batal tandai hapus' : 'Tandai untuk dihapus' }}">
                                                                    <i class="{{ $kbMarked ? 'ri-delete-bin-fill' : 'ri-delete-bin-line' }}"></i>
                                                                </button>

                                                                <input type="checkbox"
                                                                    name="delete_keberatan_reply_file_ids[]"
                                                                    value="{{ $file->id }}"
                                                                    class="kb-reply-file-delete-checkbox d-none"
                                                                    {{ $kbMarked ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>
                            @endif

                            {{-- SECTION: Notifikasi --}}
                            <div class="border-top pt-3 mt-2">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ri-notification-line text-primary me-2"></i>
                                    <h6 class="mb-0 fw-bold">Notifikasi ke Pemohon</h6>
                                </div>
                                <p class="small text-muted mb-2">
                                    Pilih cara mengirimkan informasi perubahan status kepada pemohon.
                                </p>

                                <div class="mb-3 ps-1">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="notify_whatsapp" name="notify_whatsapp" value="1">
                                        <label class="form-check-label" for="notify_whatsapp">
                                            Kirim melalui WhatsApp
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notify_email" name="notify_email" value="1">
                                        <label class="form-check-label" for="notify_email">
                                            Kirim melalui Email
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mt-2">
                                    <i class="ri-save-line me-1"></i> Simpan Semua Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/permohonan-show.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/permohonan-files.js') }}"></script>
    @endpush
</x-layout>
