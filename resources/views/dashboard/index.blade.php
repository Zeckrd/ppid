<x-layout>
        <div class="container mt-5">
            <h2 class="mb-4">📋 All Permohonan (Debug View)</h2>

            @if ($permohonans->isEmpty())
                <div class="alert alert-warning">
                    No permohonan found.
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach ($permohonans as $permohonan)
                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $permohonan->permohonan_type }}</h5>
                                    <p class="card-text">
                                        <strong>User:</strong> {{ $permohonan->user->name ?? 'Unknown' }}<br>
                                        <strong>Status:</strong> 
                                        <span class="badge bg-{{ $permohonan->status === 'approved' ? 'success' : ($permohonan->status === 'rejected' ? 'danger' : 'secondary') }}">
                                            {{ ucfirst($permohonan->status ?? 'Pending') }}
                                        </span><br>
                                        <strong>Created At:</strong> {{ $permohonan->created_at->format('d M Y H:i') }}<br>
                                        <strong>Updated At:</strong> {{ $permohonan->updated_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <a href="{{ asset('storage/' . $permohonan->permohonan_file) }}" class="btn btn-primary btn-sm" target="_blank">
                                        View File
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
</x-layout>