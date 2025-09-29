<x-layout>
    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Admin Dashboard</h1>

        <div class="row">
            {{-- Card component for each stat --}}
            @foreach ($stats as $label => $count)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-capitalize">{{ str_replace('_', ' ', $label) }}</h5>
                            <p class="display-6 fw-bold">{{ $count }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filter Buttons --}}
        <div class="mt-4 text-center">
            <h5 class="mb-3">Lihat Permohonan Berdasarkan Status</h5>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.permohonan.index', ['status' => 'all']) }}" class="btn btn-secondary">Semua</a>
                @foreach ($statuses as $status)
                    <a href="{{ route('admin.permohonan.index', ['status' => $status]) }}" class="btn btn-outline-primary">
                        {{ $status }}
                    </a>
                @endforeach
            </div>
        </div>

</x-layout>