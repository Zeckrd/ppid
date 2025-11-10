@switch($status)
    @case('Menunggu Verifikasi Berkas Dari Petugas')
        <span class="badge bg-warning text-dark"><i class="ri-time-line me-1"></i>Menunggu Verifikasi</span>
        @break
    @case('Sedang Diverifikasi petugas')
        <span class="badge bg-primary"><i class="ri-search-eye-line me-1"></i>Diverifikasi</span>
        @break
    @case('Perlu Diperbaiki')
        <span class="badge bg-danger"><i class="ri-error-warning-line me-1"></i>Perlu Diperbaiki</span>
        @break
    @case('Diproses')
        <span class="badge bg-info text-dark"><i class="ri-loader-4-line me-1"></i>Diproses</span>
        @break
    @case('Selesai')
        <span class="badge bg-success"><i class="ri-checkbox-circle-line me-1"></i>Selesai</span>
        @break
    @default
        <span class="badge bg-secondary"><i class="ri-information-line me-1"></i>{{ ucfirst($status) }}</span>
@endswitch
