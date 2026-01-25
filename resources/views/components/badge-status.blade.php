@props(['status' => null])

@php
  $status = $status ?? '-';

  $map = [
    'Menunggu Verifikasi' => [
      'class' => 'badge-status--menunggu-verifikasi',
      'icon'  => 'ri-time-line',
      'label' => 'Menunggu Verifikasi',
    ],
    'Sedang Diverifikasi' => [
      'class' => 'badge-status--sedang-diverifikasi',
      'icon'  => 'ri-search-eye-line',
      'label' => 'Sedang Diverifikasi',
    ],
    'Diproses' => [
      'class' => 'badge-status--diproses',
      'icon'  => 'ri-loader-4-line',
      'label' => 'Diproses',
    ],
    'Menunggu Pembayaran' => [
      'class' => 'badge-status--menunggu-pembayaran',
      'icon'  => 'ri-wallet-3-line',
      'label' => 'Menunggu Pembayaran',
    ],
    'Memverifikasi Pembayaran' => [
      'class' => 'badge-status--memverifikasi-pembayaran',
      'icon'  => 'ri-secure-payment-line',
      'label' => 'Memverifikasi Pembayaran',
    ],
    'Diterima' => [
      'class' => 'badge-status--diterima',
      'icon'  => 'ri-checkbox-circle-line',
      'label' => 'Diterima',
    ],
    'Perlu Diperbaiki' => [
      'class' => 'badge-status--perlu-diperbaiki',
      'icon'  => 'ri-error-warning-line',
      'label' => 'Perlu Diperbaiki',
    ],
    'Ditolak' => [
      'class' => 'badge-status--ditolak',
      'icon'  => 'ri-close-circle-line',
      'label' => 'Ditolak',
    ],
  ];

  $cfg = $map[$status] ?? [
    'class' => 'bg-secondary text-white',
    'icon'  => 'ri-information-line',
    'label' => is_string($status) ? ucfirst($status) : '-',
  ];
@endphp

<span {{ $attributes->merge(['class' => 'badge badge-status ' . $cfg['class']]) }}>
  <i class="{{ $cfg['icon'] }} me-1"></i>{{ $cfg['label'] }}
</span>
