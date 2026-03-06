<x-layout>
    <div class="container mt-5 pt-5 pb-5">

        @php
            $canEditPermohonan = auth()->check() && auth()->user()->can('update', $permohonan);

            $canUploadProof = in_array($permohonan->status, ['Menunggu Pembayaran', 'Perlu Diperbaiki'], true);
            $bukti = $permohonan->buktiBayar;

            $proofHint = match($permohonan->status) {
                'Menunggu Pembayaran' => 'Silakan unggah bukti pembayaran agar dapat diverifikasi oleh petugas.',
                'Perlu Diperbaiki'    => 'Bukti pembayaran perlu diperbaiki. Mohon unggah ulang sesuai catatan petugas.',
                default              => 'Bukti pembayaran tidak dapat diubah pada status ini.',
            };
        @endphp

        <!-- Page Header -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3 mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <a href="/dashboard" class="text-muted text-decoration-none">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                    <h3 class="mb-0">Detail Permohonan Informasi</h3>
                </div>

                <p class="text-muted mb-0">Informasi lengkap tentang permohonan Anda</p>
            </div>

            @if($canEditPermohonan)
                <a href="{{ route('user.permohonan.edit', $permohonan) }}" class="btn btn-warning">
                    <i class="ri-edit-line me-1"></i> Edit Permohonan
                </a>
            @endif
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
        @elseif($permohonan->status == 'Menunggu Verifikasi' || $permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
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

        <!-- Ringkasan Permohonan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <i class="ri-file-line text-primary me-2" style="font-size: 1.4rem;"></i>
                    <h5 class="mb-0 fw-bold">Ringkasan Permohonan</h5>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <i class="ri-flag-line text-muted me-2 mt-1"></i>
                            <div>
                                <div class="text-muted small mb-1">Status</div>
                                <div class="fw-medium">{{ $permohonan->status }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <i class="ri-file-list-3-line text-muted me-2 mt-1"></i>
                            <div>
                                <div class="text-muted small mb-1">Jenis Permohonan</div>
                                <div class="fw-medium">{{ ucfirst($permohonan->permohonan_type) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <i class="ri-calendar-line text-muted me-2 mt-1"></i>
                            <div>
                                <div class="text-muted small mb-1">Dibuat Pada</div>
                                <div class="fw-medium">{{ $permohonan->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="d-flex align-items-start">
                            <i class="ri-mail-line text-muted me-2 mt-1"></i>
                            <div>
                                <div class="text-muted small mb-1">Jenis Balasan</div>
                                <div class="fw-medium">{{ ucfirst($permohonan->reply_type) }}</div>
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
                    <div class="mb-0">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-admin-line text-info me-2"></i>
                            <h6 class="mb-0 fw-bold">Keterangan Petugas</h6>
                        </div>
                        <div class="p-3 rounded border" style="background-color: #e7f3ff;">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $permohonan->keterangan_petugas }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bukti Pembayaran -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3 mb-4">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <i class="ri-secure-payment-line text-primary"></i>
                            <h5 class="mb-0 fw-bold">Bukti Pembayaran</h5>

                            @if($bukti)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    Sudah diunggah
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    Belum ada
                                </span>
                            @endif
                        </div>

                        <p class="text-muted mb-0">{{ $proofHint }}</p>
                    </div>
                </div>

                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-7">
                        <div class="payment-info-card h-100">
                            <div class="payment-meta-item">
                                <div class="payment-meta-label">Status Bukti</div>
                                <div class="payment-meta-value">
                                    {{ $bukti ? 'File telah diunggah' : 'Belum ada file diunggah' }}
                                </div>
                            </div>

                            <div class="payment-meta-item">
                                <div class="payment-meta-label">Format Didukung</div>
                                <div class="payment-meta-value">JPG, PNG, PDF</div>
                            </div>

                            <div class="payment-meta-item">
                                <div class="payment-meta-label">Ukuran Maksimum</div>
                                <div class="payment-meta-value">5 MB</div>
                            </div>

                            @if($bukti && $bukti->created_at)
                                <div class="payment-meta-item mb-0">
                                    <div class="payment-meta-label">Terakhir Diunggah</div>
                                    <div class="payment-meta-value">{{ $bukti->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            @endif

                            @if($bukti)
                                <div class="mt-4 d-flex flex-wrap gap-2">
                                    <a href="{{ route('user.permohonan.bukti-bayar.view', $permohonan) }}"
                                       target="_blank"
                                       class="btn btn-outline-secondary">
                                        <i class="ri-eye-line me-1"></i> Lihat File
                                    </a>
                                    <a href="{{ route('user.permohonan.bukti-bayar.download', $permohonan) }}"
                                       target="_blank"
                                       class="btn btn-outline-primary">
                                        <i class="ri-download-line me-1"></i> Download
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-5">
                        @if($canUploadProof)
                            <form
                                action="{{ $bukti
                                    ? route('user.permohonan.bukti-bayar.update', $permohonan)
                                    : route('user.permohonan.bukti-bayar.store', $permohonan) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="h-100"
                            >
                                @csrf
                                @if($bukti) @method('PUT') @endif

                                <input
                                    type="file"
                                    name="bukti_bayar"
                                    id="bukti_bayar"
                                    class="d-none"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    onchange="this.form.submit()"
                                />

                                <label for="bukti_bayar" class="payment-upload-card h-100 w-100">
                                    <div class="payment-upload-icon mb-3">
                                        <i class="ri-upload-cloud-2-line"></i>
                                    </div>

                                    <div class="fw-bold mb-1">
                                        {{ $bukti ? 'Ganti Bukti Pembayaran' : 'Unggah Bukti Pembayaran' }}
                                    </div>

                                    <div class="text-muted small mb-3">
                                        Klik untuk memilih file dari perangkat Anda
                                    </div>

                                    <span class="btn btn-primary btn-sm">
                                        {{ $bukti ? 'Pilih File Baru' : 'Pilih File' }}
                                    </span>
                                </label>

                                @error('bukti_bayar')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </form>
                        @else
                            <div class="payment-upload-card payment-upload-card--disabled h-100 w-100" role="button" aria-disabled="true">
                                <div class="payment-upload-icon mb-3">
                                    <i class="ri-lock-2-line"></i>
                                </div>

                                <div class="fw-bold text-muted mb-1">Upload Belum Tersedia</div>
                                <div class="text-muted small">
                                    Bukti pembayaran tidak dapat diubah pada status ini.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        

        <!-- File Permohonan & File Balasan -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <i class="ri-folder-line text-primary me-2" style="font-size: 1.4rem;"></i>
                    <h5 class="mb-0 fw-bold">Dokumen Permohonan</h5>
                </div>

                <div class="row g-4 mb-0">
                    {{-- File Permohonan (User upload) --}}
                    <div class="col-md-6">
                        <div class="mb-0">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ri-file-text-line text-primary me-2"></i>
                                <h6 class="mb-0 fw-bold">File Permohonan</h6>
                            </div>

                            @if($permohonan->files->count())
                                <ul class="list-group mb-0">
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
                                <div class="text-center py-3 text-muted border rounded bg-light">
                                    <i class="ri-file-forbid-line" style="font-size: 2rem; opacity: 0.3;"></i>
                                    <p class="small mb-0 mt-2">Tidak ada file</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- File Balasan dari Admin --}}
                    <div class="col-md-6">
                        <div class="mb-0">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ri-mail-check-line text-success me-2"></i>
                                <h6 class="mb-0 fw-bold">File Balasan</h6>
                            </div>

                            @if($permohonan->replyFiles->count())
                                <ul class="list-group mb-0">
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
                                <div class="text-center py-3 text-muted border rounded bg-light">
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
                @if($permohonan->keberatan)
                    @php
                        $k = $permohonan->keberatan;
                        $status = $k->status ?? 'Pending';
                        $canEditKeberatan = auth()->check() && auth()->user()->can('update', $k);
                    @endphp

                    <!-- Keberatan Header -->
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3 mb-4">
                        <div>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                <div class="d-flex align-items-center">
                                    <i class="ri-alert-line text-danger me-2" style="font-size: 1.4rem;"></i>
                                    <h5 class="mb-0 fw-bold">Keberatan Atas Informasi</h5>
                                </div>
                            </div>
                            <p class="text-muted mb-0">Informasi dan dokumen keberatan atas permohonan ini.</p>
                        </div>

                        @if($canEditKeberatan)
                            <a href="{{ route('user.keberatan.edit', $k) }}" class="btn btn-warning">
                                <i class="ri-edit-line me-1"></i> Edit Keberatan
                            </a>
                        @endif
                    </div>

                    <!-- Keberatan Summary -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-xl-3">
                            <div class="d-flex align-items-start">
                                <i class="ri-flag-line text-muted me-2 mt-1"></i>
                                <div>
                                    <div class="text-muted small mb-1">Status</div>
                                    <div class="fw-medium">{{ ucfirst($status) }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="d-flex align-items-start">
                                <i class="ri-calendar-event-line text-muted me-2 mt-1"></i>
                                <div>
                                    <div class="text-muted small mb-1">Diajukan Pada</div>
                                    <div class="fw-medium">{{ $k->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="d-flex align-items-start">
                                <i class="ri-time-line text-muted me-2 mt-1"></i>
                                <div>
                                    <div class="text-muted small mb-1">Terakhir Diperbarui</div>
                                    <div class="fw-medium">{{ $k->updated_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>


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

                    <!-- Keberatan Files -->
                    <div class="row g-4 mb-0">
                        {{-- File Keberatan --}}
                        <div class="col-md-6">
                            <div class="mb-0">
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

                        {{-- File Balasan Keberatan --}}
                        <div class="col-md-6">
                            <div class="mb-0">
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
                    <!-- Empty / CTA State -->
                    <div class="d-flex align-items-center mb-4">
                        <i class="ri-alert-line text-danger me-2" style="font-size: 1.4rem;"></i>
                        <h5 class="mb-0 fw-bold">Keberatan Atas Informasi</h5>
                    </div>

                    @if(in_array($permohonan->status, ['Perlu Diperbaiki', 'Diterima', 'Ditolak']))
                        <div class="p-3 p-md-4 rounded border" style="background-color: #f8f9fa;">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="ri-information-line text-info" style="font-size: 1.8rem;"></i>
                                    <div>
                                        <div class="fw-semibold mb-1">Anda dapat mengajukan keberatan</div>
                                        <div class="small text-muted">
                                            Jika Anda tidak puas dengan hasil permohonan informasi, silakan ajukan keberatan.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-auto">
                                    <a href="{{ route('user.keberatan.create', $permohonan->id) }}"
                                       class="btn btn-danger w-100 w-md-auto">
                                        <i class="ri-add-line me-1"></i> Buat Keberatan
                                    </a>
                                </div>
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

        <style>
            .summary-item {
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 14px;
                padding: 1rem;
            }

            .summary-label {
                font-size: 0.8rem;
                color: #6c757d;
                margin-bottom: 0.35rem;
            }

            .summary-value {
                font-weight: 600;
                color: #212529;
                line-height: 1.4;
            }

            .payment-info-card {
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 16px;
                padding: 1rem 1.1rem;
                height: 100%;
            }

            .payment-meta-item {
                margin-bottom: 1rem;
            }

            .payment-meta-label {
                font-size: 0.8rem;
                color: #6c757d;
                margin-bottom: 0.25rem;
            }

            .payment-meta-value {
                font-weight: 600;
                color: #212529;
            }

            .payment-upload-card {
                border: 1.5px dashed #cfd4da;
                border-radius: 16px;
                background: #fff;
                min-height: 100%;
                padding: 1.5rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .payment-upload-card:hover {
                border-color: #0d6efd;
                background: #f8fbff;
            }

            .payment-upload-card--disabled {
                cursor: not-allowed;
                background: #f8f9fa;
                border-style: solid;
            }

            .payment-upload-card--disabled:hover {
                border-color: #cfd4da;
                background: #f8f9fa;
            }

            .payment-upload-icon {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                background: #eef4ff;
                color: #0d6efd;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
            }

            .min-width-0 {
                min-width: 0;
            }

            @media (max-width: 767.98px) {
                .summary-item,
                .payment-info-card,
                .payment-upload-card {
                    border-radius: 12px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('js/permohonan-files.js') }}"></script>
    @endpush
</x-layout>