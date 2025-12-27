<x-layout>
    <div class="container mt-5 pt-5 pb-5">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <a href="{{ route('user.permohonan.show', $permohonan->id) }}" class="text-muted text-decoration-none">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>
                <h3 class="mb-1">Edit Permohonan</h3>
                <p class="text-muted mb-0">Perbarui informasi permohonan Anda</p>
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

        {{-- Status Alert for Perlu Diperbaiki --}}
        @if($permohonan->status == 'Perlu Diperbaiki' && $permohonan->keterangan_petugas)
            <div class="alert alert-warning mb-4 d-flex align-items-start border-0 shadow-sm">
                <i class="ri-error-warning-line me-3 mt-1" style="font-size: 1.5rem;"></i>
                <div class="flex-grow-1">
                    <h6 class="alert-heading mb-2 fw-bold">Permohonan Perlu Diperbaiki</h6>
                    <p class="mb-2"><strong>Keterangan Petugas:</strong></p>
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $permohonan->keterangan_petugas }}</p>
                </div>
            </div>
        @endif

        <form action="{{ route('user.permohonan.update', $permohonan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Status Banner -->
                    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2 p-3 rounded mb-4"
                            style="background-color: #f8f9fa;">
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle"
                                style="width: 48px; height: 48px;">
                            <i class="ri-edit-line text-primary" style="font-size: 1.5rem;"></i>
                            </div>

                            <div>
                            <h5 class="mb-1 fw-bold">Permohonan #{{ $permohonan->id }}</h5>
                            <div class="text-muted small">Sedang dalam mode edit</div>
                            </div>
                        </div>
                    </div>


                    <!-- Form Fields -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="permohonan_type" class="form-label">
                                <i class="ri-file-list-line me-1 text-primary"></i>
                                <span class="fw-bold">Jenis Permohonan</span>
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('permohonan_type') is-invalid @enderror"
                                    id="permohonan_type" name="permohonan_type" required>
                                <option value="biasa" {{ $permohonan->permohonan_type == 'biasa' ? 'selected' : '' }}>
                                    Biasa
                                </option>
                                <option value="khusus" {{ $permohonan->permohonan_type == 'khusus' ? 'selected' : '' }}>
                                    Khusus
                                </option>
                            </select>
                            <x-form-error name="permohonan_type"></x-form-error>
                            <div class="form-text small text-muted">
                                <i class="ri-information-line"></i>
                                Pilih jenis permohonan yang sesuai
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="reply_type" class="form-label">
                                <i class="ri-mail-line me-1 text-primary"></i>
                                <span class="fw-bold">Jenis Balasan</span>
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('reply_type') is-invalid @enderror"
                                    id="reply_type" name="reply_type" required>
                                <option value="softcopy" {{ $permohonan->reply_type == 'softcopy' ? 'selected' : '' }}>
                                    Softcopy
                                </option>
                                <option value="hardcopy" {{ $permohonan->reply_type == 'hardcopy' ? 'selected' : '' }}>
                                    Hardcopy
                                </option>
                            </select>
                            <x-form-error name="reply_type"></x-form-error>
                            <div class="form-text small text-muted">
                                <i class="ri-information-line"></i>
                                Pilih format balasan yang diinginkan
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="keterangan_user" class="form-label">
                            <i class="ri-message-3-line me-1 text-primary"></i>
                            <span class="fw-bold">Keterangan</span>
                            <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('keterangan_user') is-invalid @enderror"
                                  id="keterangan_user"
                                  name="keterangan_user"
                                  rows="5"
                                  required
                                  placeholder="Jelaskan detail permohonan Anda dengan jelas...">{{ old('keterangan_user', $permohonan->keterangan_user) }}</textarea>
                        <x-form-error name="keterangan_user"></x-form-error>
                        <div class="form-text small text-muted">
                            <i class="ri-information-line"></i>
                            Berikan penjelasan lengkap tentang permohonan Anda
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- File Section --}}
                    @php
                        $canEditFiles = in_array(
                            $permohonan->status,
                            ['Menunggu Verifikasi Berkas Dari Petugas', 'Perlu Diperbaiki']
                        );
                    @endphp

                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-file-text-line text-primary me-2"></i>
                            <h6 class="mb-0 fw-bold">Dokumen Permohonan</h6>
                        </div>

                        <!-- Download Format Alert -->
                        <div class="alert alert-info border-0 d-flex align-items-start mb-3">
                            <i class="ri-information-line me-3 mt-1" style="font-size: 1.5rem;"></i>
                            <div class="flex-grow-1">
                                <div class="fw-semibold mb-2">Unduh format formulir terlebih dahulu</div>
                                <p class="small mb-2">Isi dan unggah formulir sesuai dengan format yang disediakan.</p>
                                <a href="https://drive.google.com/file/d/1w2YJRxdMBdEyeeiB06He_R9oSqakNyxj/"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="ri-download-cloud-line me-1"></i> Download Format Formulir
                                </a>
                            </div>
                        </div>

                        {{-- Existing files --}}
                        @if($permohonan->files->count())
                            <div class="mb-3">
                                <div class="small fw-semibold mb-2">File saat ini:</div>
                                <ul class="list-group">
                                    @foreach($permohonan->files as $file)
                                        @php
                                            $isMarked = is_array(old('delete_file_ids')) && in_array($file->id, old('delete_file_ids'));
                                        @endphp

                                        <li class="list-group-item user-file-item {{ $isMarked ? 'user-file-marked-for-deletion' : '' }}">
                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                <div class="flex-grow-1 min-width-0">
                                                    <div class="fw-medium text-truncate user-file-name" title="{{ $file->original_name }}">
                                                        <i class="ri-file-line me-1"></i>
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
                                                    {{-- View (PDF only) --}}
                                                    @if($file->isPdf())
                                                        <a href="{{ route('user.permohonan.files.view', [$permohonan->id, $file->id]) }}"
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

                                                    {{-- Download (all types) --}}
                                                    <a href="{{ route('user.permohonan.files.download', [$permohonan->id, $file->id]) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Download">
                                                        <i class="ri-download-line"></i>
                                                    </a>

                                                    {{-- Delete toggle (mark then save) --}}
                                                    @if($canEditFiles)
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger user-file-delete-toggle"
                                                                data-file-id="{{ $file->id }}"
                                                                title="{{ $isMarked ? 'Batal tandai hapus' : 'Tandai untuk dihapus' }}">
                                                            <i class="{{ $isMarked ? 'ri-delete-bin-fill' : 'ri-delete-bin-line' }}"></i>
                                                        </button>

                                                        {{-- Hidden checkbox actually sent to backend --}}
                                                        <input type="checkbox"
                                                            name="delete_file_ids[]"
                                                            value="{{ $file->id }}"
                                                            id="delete_file_{{ $file->id }}"
                                                            class="user-file-delete-checkbox d-none"
                                                            {{ $isMarked ? 'checked' : '' }}>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="form-text small text-muted mt-1">
                                    <i class="ri-information-line"></i>
                                    File yang ditandai dengan ikon tempat sampah akan dihapus setelah Anda menyimpan perubahan.
                                </div>
                            </div>
                        @else
                            <div class="p-3 mb-3 bg-light border rounded text-muted small">
                                <i class="ri-file-forbid-line me-1"></i> Belum ada file terlampir.
                            </div>
                        @endif

                        {{-- Add new files (only when allowed) --}}
                        @if($canEditFiles)
                            <label for="permohonan_files" class="form-label">
                                <i class="ri-upload-cloud-line me-1"></i>
                                <span class="fw-bold">Tambah File Permohonan</span>
                            </label>
                            <input type="file"
                                class="form-control
                                    @error('permohonan_files') is-invalid @enderror
                                    @error('permohonan_files.*') is-invalid @enderror"
                                id="permohonan_files"
                                name="permohonan_files[]"
                                accept=".pdf,.doc,.docx"
                                multiple>
                            <x-form-error name="permohonan_files"></x-form-error>
                            <x-form-error name="permohonan_files.*"></x-form-error>
                            <div id="permohonan_files_error" class="invalid-feedback"></div>
                            <div class="form-text small text-muted">
                                <i class="ri-information-line"></i>
                                Anda dapat menambah file baru. Total maksimal 10 file, masing-masing 5 MB.
                            </div>

                            {{-- Preview files about to be uploaded --}}
                            <div id="permohonan_files_preview" class="mt-2 d-none">
                                <div class="small text-muted d-flex align-items-start gap-2 flex-wrap">
                                    <span class="mt-1">
                                        <i class="ri-upload-2-line me-1"></i>
                                        File yang akan diunggah:
                                    </span>
                                    <div id="permohonan_files_preview_chips" class="d-flex flex-wrap gap-1"></div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-secondary mt-3 mb-0 small">
                                <i class="ri-information-line me-1"></i>
                                File tidak dapat diubah pada status ini.
                            </div>
                        @endif


                    <!-- Action Buttons -->
                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-between align-items-stretch align-items-md-center mt-4">
                        <a href="{{ route('user.permohonan.show', $permohonan->id) }}"
                            class="btn btn-outline-secondary col-12 col-md-auto">
                            <i class="ri-close-line me-1"></i> Batal
                        </a>

                        <button type="submit" class="btn btn-primary px-4 col-12 col-md-auto">
                            <i class="ri-save-line me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div> 
            </div>
        </form>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/permohonan-show.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('js/permohonan-files.js') }}"></script>
    @endpush

</x-layout>
