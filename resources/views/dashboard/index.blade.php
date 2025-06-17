<x-layout>
    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Daftar Permohonan</h3>
            <a href="/dashboard/create" class="btn btn-primary">Tambah Pengajuan</a>
        </div>

        {{-- CHECK IF PERMOHONAN IS EMTPY RETURN WARNING INSTEAD --}}
        @if($permohonans->isEmpty())
            <div class="alert alert-warning" role="alert">
                Anda belum membuat permohonan apapun. Silakan klik tombol "Tambah Pengajuan" untuk mengajukan permohonan.
            </div>
        @else
            <table class="table table-no-inner-border table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Waktu Dibuat</th>
                        <th>Jenis Permohonan</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permohonans as $index => $permohonan)
                        <tr class="cursor-default">
                            <td>{{ $permohonan->created_at->format('d M Y, H:i') }}</td>
                            {{-- TIPE PERMOHONAN --}}
                            <td>{{ ucfirst($permohonan->permohonan_type) }}</td>
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
                            <td colspan="4" class="text-end">
                                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detil</a>
                                {{-- <a href="{{ route('#', $permohonan->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detil</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        @endif
        {{-- PAGE 1 2 3 --}}
        <div class="d-flex justify-content-center my-4">
            {{ $permohonans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-layout>