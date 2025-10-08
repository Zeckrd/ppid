<x-layout>
    <form method="POST" action="{{ route('user.permohonan.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Form Permohonan Informasi</h4>
                            {{-- Jenis Permohonan --}}
                            <div class="mb-3">
                                <label for="permohonan_type" class="form-label">Jenis Permohonan *</label>
                                <select class="form-select" name="permohonan_type" id="permohonan_type" required>
                                    <option value="biasa">Biasa</option>
                                    <option value="khusus">Khusus</option>
                                </select>
                                <x-form-error name='permohonan_type'></x-form-error>
                            </div>

                            {{-- Link Download Format --}}
                            <div class="mb-2">
                                <a href="https://drive.google.com/file/d/1w2YJRxdMBdEyeeiB06He_R9oSqakNyxj/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    Download Format Formulir
                                </a>
                                <p class="text-muted mt-2 mb-0" style="font-size: 0.9rem;">
                                    Isi dan Unggah formulir di atas sesuai dengan format yang disediakan.
                                </p>
                            </div>

                            {{-- File Permohonan --}}
                            <div class="mb-3 mt-2">
                                <label for="permohonan_file" class="form-label">Unggah File Permohonan *</label>
                                <input type="file" name="permohonan_file" id="permohonan_file" class="form-control" required accept=".pdf,.doc,.docx">
                                <p class="text-muted mt-2 mb-0" style="font-size: 0.9rem;">
                                    Tipe File : .pdf, .doc, .docx, dan ukuran dibawah 2 MB
                                </p>
                                <x-form-error name='permohonan_file'></x-form-error>
                            </div>

                            {{-- Keterangan --}}
                            <div class="mb-3">
                                <label for="keterangan_user" class="form-label">Keterangan *</label>
                                <textarea name="keterangan_user" id="keterangan_user" class="form-control" rows="4" required></textarea>
                                <x-form-error name='keterangan_user'></x-form-error>
                            </div>

                            {{-- Jenis Balasan --}}
                            <div class="mb-4">
                                <label for="reply_type" class="form-label">Jenis Balasan *</label>
                                <select class="form-select" name="reply_type" id="reply_type" required>
                                    <option value="softcopy">Softcopy</option>
                                    <option value="hardcopy">Hardcopy</option>
                                </select>
                                <x-form-error name='reply_type'></x-form-error>
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Kirim Permohonan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout>
