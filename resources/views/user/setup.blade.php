<x-layout>
    <div class="container mt-5 pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                
                <div class="card shadow border-0">
                    <div class="card-body p-4">

                        {{-- header --}}
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Verifikasi Diperlukan</h4>
                            <p class="text-muted mb-0">
                                Akun Anda sudah terdaftar, namun nomor WhatsApp Anda belum diverifikasi.
                            </p>
                        </div>

                        {{-- status box --}}

                        <div class="alert alert-warning d-flex align-items-center gap-2">
                            <i class="ri-error-warning-line fs-4"></i>
                            <span>
                                Anda harus memverifikasi nomor WhatsApp sebelum dapat mengakses dashboard.
                            </span>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success mb-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger mb-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-info mb-3">
                                📩 Link verifikasi telah dikirim ke <strong>{{ auth()->user()->phone }}</strong>.  
                                Silakan cek WhatsApp Anda.
                            </div>
                        @endif

                        {{-- buttons --}}
                        <div class="d-flex flex-column gap-3 mt-4">

                            {{-- edit profile --}}
                            <a href="{{ route('user.profile.edit') }}" 
                               class="btn btn-primary w-100">
                                Edit Profil (Email / No. WhatsApp / Nama)
                            </a>

                            {{-- reverify phone --}}
                            <form action="{{ route('phone.send') }}" method="POST">
                                @csrf

                                @php
                                    $verification = \App\Models\PhoneVerification::where('user_id', auth()->id())->first();
                                    $cooldown = 0;

                                    if ($verification && $verification->last_sent_at) {
                                        $secondsSince = now()->diffInSeconds($verification->last_sent_at);
                                        if ($secondsSince < 120) {
                                            $cooldown = 120 - $secondsSince;
                                        }
                                    }
                                @endphp

                                @if($cooldown > 0)
                                    <button type="button" class="btn btn-secondary w-100" disabled>
                                        Tunggu {{ $cooldown }} detik untuk mengirim ulang
                                    </button>
                                @else
                                    <button class="btn btn-primary w-100">
                                        Kirim Ulang Link Verifikasi
                                    </button>
                                @endif
                            </form>

                            {{-- logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-light border w-100">
                                    Logout
                                </button>
                            </form>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>
