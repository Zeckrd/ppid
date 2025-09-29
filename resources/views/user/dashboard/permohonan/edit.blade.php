<x-layout>
    <form action="{{ route('dashboard.update', $permohonan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="container mt-5 pt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Edit Permohonan</h3>
                <a href="{{ route('dashboard.show', $permohonan->id) }}" class="btn btn-secondary">Kembali Ke Daftar</a>
            </div>

            {{-- success/error message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Permohonan #{{ $permohonan->id }}</h5>
                    <small class="text-muted">
                        Status: 
                        @if($permohonan->status == 'Perlu Diperbaiki')
                            <span class="badge bg-danger">Perlu Diperbaiki</span>
                        @else
                            <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                        @endif
                    </small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="permohonan_type" class="form-label">Jenis Permohonan *</label>
                                <select class="form-select @error('permohonan_type') is-invalid @enderror" 
                                        id="permohonan_type" name="permohonan_type" required>
                                    <option value="biasa" {{ $permohonan->permohonan_type == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="khusus" {{ $permohonan->permohonan_type == 'khusus' ? 'selected' : '' }}>Khusus</option>
                                </select>
                                <x-form-error name='permohonan-type'></x-form-error>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reply_type" class="form-label">Jenis Balasan *</label>
                                <select class="form-select @error('reply_type') is-invalid @enderror" 
                                        id="reply_type" name="reply_type" required>
                                    <option value="softcopy" {{ $permohonan->reply_type == 'softcopy' ? 'selected' : '' }}>Softcopy</option>
                                    <option value="hardcopy" {{ $permohonan->reply_type == 'hardcopy' ? 'selected' : '' }}>Hardcopy</option>
                                </select>
                                <x-form-error name='reply-type'></x-form-error>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_user" class="form-label">Keterangan *</label>
                        <textarea class="form-control @error('keterangan_user') is-invalid @enderror" 
                                id="keterangan_user" name="keterangan_user" rows="4" required>{{ old('keterangan_user', $permohonan->keterangan_user) }}</textarea>
                        <x-form-error name='keterangan_user'></x-form-error>
                    </div>

                    <div class="mb-3">
                        <a href="https://drive.google.com/file/d/1w2YJRxdMBdEyeeiB06He_R9oSqakNyxj/" target="_blank" class="btn btn-sm btn-outline-secondary">
                            Download Format Formulir
                        </a>
                        <p class="text-muted mt-1 mb-0" style="font-size: 0.9rem;">
                            Isi dan Unggah formulir di atas sesuai dengan format yang disediakan.
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="permohonan_file" class="form-label">File Permohonan</label>
                        <input type="file" class="form-control @error('permohonan_file') is-invalid @enderror" 
                            id="permohonan_file" name="permohonan_file" 
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <x-form-error name='permohonan_file'></x-form-error>
                        <div class="form-text">
                            Tipe File : .pdf, .doc, .docx, dan ukuran dibawah 2 MB
                            <br>
                            @if($permohonan->permohonan_file)
                                File saat ini: 
                                <a href="{{ Storage::url($permohonan->permohonan_file) }}" target="_blank" class="text-primary">
                                    {{ basename($permohonan->permohonan_file) }}
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($permohonan->status == 'Perlu Diperbaiki' && $permohonan->keterangan_petugas)
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Keterangan Petugas:</h6>
                        <p class="mb-0">{{ $permohonan->keterangan_petugas }}</p>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard.show', $permohonan->id) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout>