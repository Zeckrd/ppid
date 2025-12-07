<x-layout>
    <div class="container mt-5 pt-5 pb-5">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <a href="{{ route('user.permohonan.show', $permohonan) }}" class="text-muted text-decoration-none">
                        <i class="ri-arrow-left-line"></i> Kembali
                    </a>
                </div>
                <h3 class="mb-1">Ajukan Keberatan</h3>
                <p class="text-muted mb-0">Lengkapi formulir berikut untuk mengajukan keberatan atas permohonan ini</p>
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

        <form method="POST" action="{{ route('user.keberatan.store', $permohonan) }}" enctype="multipart/form-data">
            @csrf

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Banner Section -->
                    <div class="d-flex align-items-center justify-content-between p-3 rounded mb-4" style="background-color: #f8f9fa;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle" style="width: 48px; height: 48px;">
                                <i class="ri-file-warning-line text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Form Keberatan</h5>
                                <div class="text-muted small">Isi alasan keberatan dan unggah dokumen pendukung</div>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan_user" class="form-label">
                            <i class="ri-message-3-line me-1 text-primary"></i>
                            <span class="fw-bold">Alasan / Keterangan Keberatan</span>
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="keterangan_user" id="keterangan_user" rows="5"
                            class="form-control @error('keterangan_user') is-invalid @enderror"
                            required placeholder="Tuliskan alasan keberatan Anda secara jelas">{{ old('keterangan_user') }}</textarea>
                        <x-form-error name='keterangan_user'></x-form-error>
                        <div class="form-text small text-muted">
                            <i class="ri-information-line"></i>
                            Jelaskan poin keberatan Anda sejelas mungkin.
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- File Upload Keberatan -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-file-text-line text-primary me-2"></i>
                            <h6 class="mb-0 fw-bold">Dokumen Pendukung Keberatan</h6>
                        </div>

                        <label for="keberatan_files" class="form-label">
                            <i class="ri-upload-cloud-line me-1"></i>
                            <span class="fw-bold">Upload File Keberatan</span>
                            <span class="text-danger">*</span>
                        </label>

                        <input type="file"
                            class="form-control
                                @error('keberatan_files') is-invalid @enderror
                                @error('keberatan_files.*') is-invalid @enderror"
                            id="keberatan_files"
                            name="keberatan_files[]"
                            accept=".pdf,.doc,.docx"
                            multiple>

                        {{-- Server-side validation errors --}}
                        <x-form-error name="keberatan_files"></x-form-error>
                        <x-form-error name="keberatan_files.*"></x-form-error>

                        {{-- JS validation error box --}}
                        <div id="keberatan_files_error" class="invalid-feedback d-none"></div>

                        <div class="form-text small text-muted">
                            <i class="ri-information-line"></i>
                            Format yang diterima: PDF, DOC, DOCX. Maksimal 10 file, masing-masing 5 MB.
                        </div>

                        {{-- Preview files that are about to be uploaded --}}
                        <div id="keberatan_files_preview" class="mt-2 d-none">
                            <div class="small text-muted d-flex align-items-start gap-2 flex-wrap">
                                <span class="mt-1">
                                    <i class="ri-upload-2-line me-1"></i>
                                    File yang akan diunggah:
                                </span>
                                <div id="keberatan_files_preview_chips"
                                    class="d-flex flex-wrap gap-1"></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('user.permohonan.show', $permohonan) }}" class="btn btn-outline-secondary">
                            <i class="ri-close-line me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ri-send-plane-line me-1"></i> Ajukan Keberatan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="{{ asset('js/permohonan-files.js') }}"></script>
    @endpush
</x-layout>
