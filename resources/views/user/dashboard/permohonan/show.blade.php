<x-layout>
    <div class="container mt-5 pt-5 pb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Detail Permohonan</h3>
            <div class="d-flex gap-2">
                @can('update', $permohonan)
                    <a href="{{ route('user.permohonan.edit', $permohonan) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Permohonan
                    </a>
                @endcan
                <a href="/dashboard" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Status alerts --}}
        @if($permohonan->status == 'Perlu Diperbaiki')
            <div class="alert alert-warning mb-4">
                <h6 class="alert-heading mb-1"><i class="fas fa-exclamation-triangle"></i> Permohonan Perlu Diperbaiki</h6>
                <p class="mb-0">Silakan perbaiki permohonan Anda berdasarkan keterangan petugas.</p>
            </div>
        @elseif($permohonan->status == 'Menunggu Verifikasi Berkas Dari Petugas')
            <div class="alert alert-info mb-4">
                <h6 class="alert-heading mb-1"><i class="fas fa-info-circle"></i> Status Menunggu Verifikasi</h6>
                <p class="mb-0">Permohonan Anda masih dapat diedit sebelum diverifikasi oleh petugas.</p>
            </div>
        @endif

        <div class="card shadow-sm border-1">
            <div class="card-body py-4 px-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-muted">Jenis Permohonan:</td>
                                    <td>{{ ucfirst($permohonan->permohonan_type) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Status:</td>
                                    <td>
                                        @switch($permohonan->status)
                                            @case('Menunggu Verifikasi Berkas Dari Petugas')
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                                @break
                                            @case('Sedang Diverifikasi petugas')
                                                <span class="badge bg-primary">Diverifikasi</span>
                                                @break
                                            @case('Perlu Diperbaiki')
                                                <span class="badge bg-danger">Perlu Diperbaiki</span>
                                                @break
                                            @case('Permohonan Sedang Diproses')
                                                <span class="badge bg-info text-dark">Diproses</span>
                                                @break
                                            @case('Selesai')
                                                <span class="badge bg-success">Selesai</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($permohonan->status) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Waktu Dibuat:</td>
                                    <td>{{ $permohonan->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Waktu Update:</td>
                                    <td>{{ $permohonan->updated_at->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">Jenis Balasan:</td>
                                    <td>{{ ucfirst($permohonan->reply_type) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Keterangan User --}}
                <div class="mb-4">
                    <h5 class="text-muted mb-2">Keterangan User</h5>
                    <p class="border rounded p-3 bg-light mb-0">{{ $permohonan->keterangan_user }}</p>
                </div>

                {{-- Keterangan Petugas --}}
                @if($permohonan->keterangan_petugas)
                    <div class="mb-4">
                        <h5 class="text-muted mb-2">Keterangan Petugas</h5>
                        <p class="border rounded p-3 bg-info bg-opacity-10 mb-0">{{ $permohonan->keterangan_petugas }}</p>
                    </div>
                @endif

                <hr class="my-4">

                <div class="row gy-4">
                    <div class="col-md-6">
                        <h5 class="text-muted mb-2">File Permohonan</h5>
                        @if($permohonan->permohonan_file)
                            <a href="{{ Storage::url($permohonan->permohonan_file) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fas fa-download"></i> Download File
                            </a>
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </div>

                    @if($permohonan->reply_file)
                        <div class="col-md-6">
                            <h5 class="text-muted mb-2">File Balasan</h5>
                            <a href="{{ Storage::url($permohonan->reply_file) }}" class="btn btn-outline-success btn-sm" target="_blank">
                                <i class="fas fa-download"></i> Download Balasan
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Keberatan --}}
                <hr class="my-4">
                <div>
                    <h5 class="text-muted mb-3">Keberatan</h5>

                    @if($permohonan->keberatan)
                        <div class="mb-3">
                            <p class="mb-2"><strong>Diajukan pada:</strong> {{ $permohonan->keberatan->created_at->format('d M Y, H:i') }}</p>
                            <p class="mb-1"><strong>Keterangan User:</strong></p>
                            <p class="border rounded p-3 bg-light mb-3">{{ $permohonan->keberatan->keterangan_user }}</p>

                            @if($permohonan->keberatan->keberatan_file)
                                <a href="{{ Storage::url($permohonan->keberatan->keberatan_file) }}" 
                                class="btn btn-outline-primary btn-sm" 
                                target="_blank">
                                    <i class="fas fa-download"></i> Download File Keberatan
                                </a>
                            @endif
                        </div>
                    @else
                        @if(in_array($permohonan->status, ['Perlu Diperbaiki', 'Selesai']))
                            <div class="alert alert-info d-flex justify-content-between align-items-center mt-3">
                                <span>Anda bisa mengajukan keberatan untuk permohonan ini.</span>
                                <a href="{{ route('user.keberatan.create', $permohonan->id) }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-plus"></i> Buat Keberatan
                                </a>
                            </div>
                        @else
                            <div class="alert alert-secondary mt-3">
                                <i class="fas fa-info-circle"></i> Keberatan tidak tersedia pada status ini.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
