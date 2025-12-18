{{-- DEPRECIATED --}}
Yth. {{ $permohonan->user->name ?? 'Pemohon' }},

Status permohonan Anda telah diperbarui menjadi: {{ $permohonan->status }}.

@if($permohonan->keberatan)
Status Keberatan: {{ $permohonan->keberatan->status }}
@endif

@if($permohonan->keterangan_petugas)
Keterangan Petugas: {{ $permohonan->keterangan_petugas }}
@endif

Terima kasih.
