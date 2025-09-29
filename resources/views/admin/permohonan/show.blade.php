<x-layout>
    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Detail Permohonan (Admin)</h3>
            <div>
                <a href="{{ route('admin.permohonan.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>

        {{-- Flash messages --}}
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
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">Permohonan #{{ $permohonan->id }}</h5>
                <span class="badge bg-secondary">{{ $permohonan->status }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama Pemohon:</strong></td>
                                <td>{{ $permohonan->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Permohonan:</strong></td>
                                <td>{{ ucfirst($permohonan->permohonan_type) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $permohonan->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Update Terakhir:</strong></td>
                                <td>{{ $permohonan->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <h6 class="text-muted">Keterangan User</h6>
                <p class="border p-3 bg-light rounded">{{ $permohonan->keterangan_user }}</p>

                <hr>

                {{-- Admin actions --}}
                <form action="{{ route('admin.permohonan.update', $permohonan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Update Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="Menunggu Verifikasi Berkas Dari Petugas" @selected($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')>Menunggu Verifikasi</option>
                            <option value="Sedang Diverifikasi petugas" @selected($permohonan->status == 'Sedang Diverifikasi petugas')>Sedang Diverifikasi</option>
                            <option value="Perlu Diperbaiki" @selected($permohonan->status == 'Perlu Diperbaiki')>Perlu Diperbaiki</option>
                            <option value="Permohonan Sedang Diproses" @selected($permohonan->status == 'Permohonan Sedang Diproses')>Diproses</option>
                            <option value="Selesai" @selected($permohonan->status == 'Selesai')>Selesai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_petugas" class="form-label">Keterangan Petugas</label>
                        <textarea name="keterangan_petugas" id="keterangan_petugas" class="form-control" rows="3">{{ old('keterangan_petugas', $permohonan->keterangan_petugas) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="reply_file" class="form-label">Upload File Balasan</label>
                        <input type="file" class="form-control" name="reply_file" id="reply_file">
                        @if($permohonan->reply_file)
                            <div class="mt-2">
                                <a href="{{ Storage::url($permohonan->reply_file) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-download"></i> Lihat File Balasan
                                </a>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>

                <hr>

                <div>
                    <h6 class="text-muted">File Permohonan</h6>
                    @if($permohonan->permohonan_file)
                        <a href="{{ Storage::url($permohonan->permohonan_file) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fas fa-download"></i> Download File Permohonan
                        </a>
                    @else
                        <span class="text-muted">Tidak ada file</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
