<x-layout>
    <form method="POST" action="{{ route('keberatan.store', $permohonan->id) }}"  enctype="multipart/form-data">
        @csrf

        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Form Pengajuan Keberatan</h4>
                            {{-- File Permohonan --}}
                            <div class="mb-3 mt-2">
                                <label for="keberatan_file" class="form-label">Unggah File Keberatan *</label>
                                <input type="file" name="keberatan_file" id="keberatan_file" class="form-control" required accept=".pdf,.doc,.docx">
                                <p class="text-muted mt-2 mb-0" style="font-size: 0.9rem;">
                                    Tipe File : .pdf, .doc, .docx, dan ukuran dibawah 2 MB
                                </p>
                                <x-form-error name='keberatan_file'></x-form-error>
                            </div>

                            {{-- Keterangan --}}
                            <div class="mb-3">
                                <label for="keterangan_user" class="form-label">Keterangan *</label>
                                <textarea name="keterangan_user" id="keterangan_user" class="form-control" rows="4" required></textarea>
                                <x-form-error name='keterangan_user'></x-form-error>
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
