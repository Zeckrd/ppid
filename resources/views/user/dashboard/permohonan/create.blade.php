<x-layout> 
    <div class="container mt-5 pt-5 pb-5">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div> 
                <div class="d-flex align-items-center gap-2 mb-2"> 
                    <a href="{{ route('user.dashboard.index') }}" class="text-muted text-decoration-none"> 
                        <i class="ri-arrow-left-line"></i>Kembali 
                    </a> 
                </div> 
                <h3 class="mb-1">Buat Permohonan Baru</h3> 
                <p class="text-muted mb-0">Lengkapi formulir berikut untuk mengajukan permohonan informasi</p>
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

        <form method="POST" action="{{ route('user.permohonan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Banner Section -->
                    <div class="d-flex align-items-center justify-content-between p-3 rounded mb-4" style="background-color: #f8f9fa;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle" style="width: 48px; height: 48px;">
                                <i class="ri-file-add-line text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Form Permohonan Baru</h5>
                                <div class="text-muted small">Isi data dengan lengkap dan benar</div>
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
                                    name="permohonan_type" id="permohonan_type" required>
                                <option value="">-- Pilih Jenis Permohonan --</option>
                                <option value="biasa">Biasa</option>
                                <option value="khusus">Khusus</option>
                            </select>
                            <x-form-error name='permohonan_type'></x-form-error>
                            <div class="form-text small text-muted">
                                <i class="ri-information-line"></i>
                                Pilih jenis permohonan sesuai kebutuhan Anda.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="reply_type" class="form-label">
                                <i class="ri-mail-line me-1 text-primary"></i>
                                <span class="fw-bold">Jenis Balasan</span>
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('reply_type') is-invalid @enderror"
                                    name="reply_type" id="reply_type" required>
                                <option value="">-- Pilih Jenis Balasan --</option>
                                <option value="softcopy">Softcopy</option>
                                <option value="hardcopy">Hardcopy</option>
                            </select>
                            <x-form-error name='reply_type'></x-form-error>
                            <div class="form-text small text-muted">
                                <i class="ri-information-line"></i>
                                Tentukan apakah Anda ingin menerima balasan dalam bentuk digital atau fisik.
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan_user" class="form-label">
                            <i class="ri-message-3-line me-1 text-primary"></i>
                            <span class="fw-bold">Keterangan</span>
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="keterangan_user" id="keterangan_user" rows="5"
                                class="form-control @error('keterangan_user') is-invalid @enderror"
                                required placeholder="Tuliskan detail permohonan Anda..."></textarea>
                        <x-form-error name='keterangan_user'></x-form-error>
                        <div class="form-text small text-muted">
                            <i class="ri-information-line"></i>
                            Jelaskan informasi yang Anda butuhkan secara rinci.
                        </div>
                    </div>

                    <hr class="my-4">
                        <!-- File Upload -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ri-file-text-line text-primary me-2"></i>
                                <h6 class="mb-0 fw-bold">Dokumen Permohonan</h6>
                            </div>

                            <!-- Info Alert -->
                            <div class="alert alert-info border-0 d-flex align-items-start mb-3">
                                <i class="ri-information-line me-3 mt-1" style="font-size: 1.5rem;"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold mb-2">Unduh format formulir terlebih dahulu</div>
                                    <p class="small mb-2">Isi dan unggah formulir sesuai format berikut:</p>
                                    <a href="https://drive.google.com/file/d/1w2YJRxdMBdEyeeiB06He_R9oSqakNyxj/" 
                                    target="_blank" 
                                    class="btn btn-sm btn-outline-info">
                                        <i class="ri-download-cloud-line me-1"></i> Download Format Formulir
                                    </a>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <label for="permohonan_files" class="form-label">
                                <i class="ri-upload-cloud-line me-1"></i>
                                <span class="fw-bold">Upload File Permohonan</span>
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file"
                                class="form-control
                                    @error('permohonan_files') is-invalid @enderror
                                    @error('permohonan_files.*') is-invalid @enderror"
                                id="permohonan_files"
                                name="permohonan_files[]"
                                accept=".pdf,.doc,.docx"
                                multiple>

                            {{-- Server-side validation errors --}}
                            <x-form-error name="permohonan_files"></x-form-error>
                            <x-form-error name="permohonan_files.*"></x-form-error>

                            {{-- JS validation error box --}}
                            <div id="permohonan_files_error" class="invalid-feedback d-none"></div>

                            <div class="form-text small text-muted">
                                <i class="ri-information-line"></i>
                                Format yang diterima: PDF, DOC, DOCX. Maksimal 10 file, masing-masing 5 MB.
                            </div>

                            {{-- Preview files that are about to be uploaded --}}
                            <div id="permohonan_files_preview" class="mt-2 d-none">
                                <div class="small text-muted d-flex align-items-start gap-2 flex-wrap">
                                    <span class="mt-1">
                                        <i class="ri-upload-2-line me-1"></i>
                                        File yang akan diunggah:
                                    </span>
                                    <div id="permohonan_files_preview_chips"
                                        class="d-flex flex-wrap gap-1"></div>
                                </div>
                            </div>
                        </div>
                    <hr class="my-4">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('user.dashboard.index') }}" class="btn btn-outline-secondary">
                            <i class="ri-close-line me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ri-send-plane-line me-1"></i> Kirim Permohonan
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