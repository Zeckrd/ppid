<x-layout>
    <div class="container">
        <h2>Daftar Permohonan</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pemohon</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permohonans as $permohonan)
                    <tr onclick="window.location='{{ route('admin.permohonan.show', $permohonan->id) }}'" style="cursor:pointer;">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $permohonan->user->name }}</td>
                        <td>{{ $permohonan->status }}</td>
                        <td>{{ $permohonan->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada permohonan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $permohonans->links() }}
    </div>
</x-layout>
