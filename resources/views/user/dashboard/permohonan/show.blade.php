<x-layout>
    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Detail Permohonan</h3>
            <div>
                {{-- Use Policy to check if user can update --}}
                @can('update', $permohonan)
                    <a href="{{ route('user.permohonan.edit', $permohonan) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit Permohonan
                    </a>
                @endcan
                <a href="/dashboard" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>

        {{-- Show success/error messages --}}
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

        {{-- Show alert for editable statuses --}}
        @if($permohonan->status == 'Perlu Diperbaiki')
            <div class="alert alert-warning">
                <h6 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Permohonan Perlu Diperbaiki</h6>
                <p class="mb-0">Silakan perbaiki permohonan Anda berdasarkan keterangan petugas.</p>
            </div>
        @elseif($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
            <div class="alert alert-info">
                <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Status Menunggu Verifikasi</h6>
                <p class="mb-0">Permohonan Anda masih dapat diedit sebelum diverifikasi oleh petugas.</p>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Permohonan #{{ $permohonan->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Jenis Permohonan:</strong></td>
                                <td>{{ ucfirst($permohonan->permohonan_type) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
                                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                    @elseif($permohonan->status == 'Sedang Diverifikasi petugas')
                                        <span class="badge bg-primary">Diverifikasi</span>
                                    @elseif($permohonan->status == 'Perlu Diperbaiki')
                                        <span class="badge bg-danger">Perlu Diperbaiki</span>
                                    @elseif($permohonan->status == 'Permohonan Sedang Diproses')
                                        <span class="badge bg-info text-dark">Diproses</span>
                                    @elseif($permohonan->status == 'Selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($permohonan->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Waktu Dibuat:</strong></td>
                                <td>{{ $permohonan->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Waktu Update:</strong></td>
                                <td>{{ $permohonan->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Balasan:</strong></td>
                                <td>{{ ucfirst($permohonan->reply_type) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <h6 class="text-muted">Keterangan User</h6>
                        <p class="border p-3 bg-light rounded">{{ $permohonan->keterangan_user }}</p>
                    </div>
                </div>

                @if($permohonan->keterangan_petugas)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-muted">Keterangan Petugas</h6>
                        <p class="border p-3 bg-info bg-opacity-10 rounded">{{ $permohonan->keterangan_petugas }}</p>
                    </div>
                </div>
                @endif

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">File Permohonan</h6>
                        @if($permohonan->permohonan_file)
                            <a href="{{ Storage::url($permohonan->permohonan_file) }}" 
                               class="btn btn-outline-primary btn-sm" 
                               target="_blank">
                                <i class="fas fa-download"></i> Download File
                            </a>
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </div>
                    
                    @if($permohonan->reply_file)
                    <div class="col-md-6">
                        <h6 class="text-muted">File Balasan</h6>
                        <a href="{{ Storage::url($permohonan->reply_file) }}" 
                           class="btn btn-outline-success btn-sm" 
                           target="_blank">
                            <i class="fas fa-download"></i> Download Balasan
                        </a>
                    </div>
                    @endif
                    @if(in_array($permohonan->status, ['Perlu Diperbaiki', 'Selesai']))
                        <hr>

                        <div class="mt-2">
                            <h5 class="text-muted">Keberatan</h5>

                            @if($permohonan->keberatan)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <p><strong>Diajukan pada:</strong> {{ $permohonan->keberatan->created_at->format('d M Y, H:i') }}</p>
                                        <p><strong>Keterangan User:</strong></p>
                                        <p class="border p-3 bg-light rounded">
                                            {{ $permohonan->keberatan->keterangan_user }}
                                        </p>

                                        @if($permohonan->keberatan->keberatan_file)
                                            <a href="{{ Storage::url($permohonan->keberatan->keberatan_file) }}"
                                            class="btn btn-outline-primary btn-sm"
                                            target="_blank">
                                                <i class="fas fa-download"></i> Download File Keberatan
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info d-flex justify-content-between align-items-center">
                                    <div>
                                        Anda bisa mengajukan keberatan untuk permohonan ini.
                                    </div>
                                    <a href="{{ route('user.keberatan.create', $permohonan->id) }}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-plus"></i> Buat Keberatan
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-layout>
