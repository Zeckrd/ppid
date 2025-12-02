<x-layout>
    <section class="my-4 mx-3 mx-md-5">
        <div class="container">
            <div class="row justify-content-center">

                {{-- Sidebar nav --}}
                <div class="col-md-3 mb-3">
                    <div class="position-sticky" style="top: 80px; z-index: 100;">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-3">
                                <h6 class="text-uppercase text-muted small mb-3">Pengaturan Akun</h6>
                                <div class="nav flex-column nav-pills" id="profile-settings-nav" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link active text-start mb-1"
                                            type="button"
                                            data-scroll-target="#section-basic">
                                        Profil Dasar
                                    </button>
                                    <button class="nav-link text-start mb-1"
                                            type="button"
                                            data-scroll-target="#section-whatsapp">
                                        Nomor WhatsApp
                                    </button>
                                    <button class="nav-link text-start mb-1"
                                            type="button"
                                            data-scroll-target="#section-email">
                                        Ubah Email
                                    </button>
                                    <button class="nav-link text-start"
                                            type="button"
                                            data-scroll-target="#section-password">
                                        Ubah Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="col-md-9">
                    {{-- Alerts --}}
                    <x-alert type="error" />
                    <x-alert type="success" />

                    {{-- ========== SECTION: BASIC PROFILE ========== --}}
                    <div id="section-basic" class="card shadow border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-1">Profil Dasar</h4>
                                    <p class="text-muted small mb-0">
                                        Atur nama, pekerjaan, dan nomor WhatsApp Anda.
                                    </p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('user.profile.update') }}" id="basicProfileForm">
                                @csrf

                                {{-- Nama --}}
                                <x-form.input
                                    name="name"
                                    label="Nama Lengkap"
                                    :value="old('name', $user->name)"
                                    required
                                />

                                {{-- Pekerjaan --}}
                                <x-form.select
                                    name="pekerjaan"
                                    label="Pekerjaan"
                                    :selected="old('pekerjaan', $user->pekerjaan)"
                                    :options="[
                                        'Wiraswasta' => 'Wiraswasta',
                                        'Karyawan Swasta' => 'Karyawan Swasta',
                                        'Pelajar/Mahasiswa' => 'Pelajar/Mahasiswa',
                                        'PNS/ASN' => 'PNS/ASN',
                                        'TNI/Polri' => 'TNI/Polri',
                                        'Pengacara/Advocat' => 'Pengacara/Advocat',
                                        'Buruh' => 'Buruh',
                                        'Lainnya' => 'Lainnya',
                                    ]"
                                />

                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <span>Update Profil</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ========== WHATSAPP NUMBER ========== --}}
                    <div id="section-whatsapp" class="card shadow border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-1">Nomor WhatsApp</h4>
                                    <p class="text-muted small mb-0">
                                        Nomor ini digunakan untuk verifikasi akun dan notifikasi.
                                    </p>
                                </div>

                                @if($user->phone_verified_at)
                                    <span class="badge bg-success text-white">
                                        <i class="bi bi-check-circle me-1"></i>
                                        WA Terverifikasi
                                    </span>
                                @else
                                    <span class="badge bg-warning text-black">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        WA belum terverifikasi
                                    </span>
                                @endif
                            </div>

                            {{-- Satu form saja untuk update + kirim / kirim ulang verifikasi --}}
                            <form method="POST" action="{{ route('user.profile.phone.update') }}" id="changePhoneForm">
                                @csrf

                                {{-- Nomor WhatsApp saat ini (hanya info) --}}
                                <div class="mb-3">
                                    <label class="form-label">Nomor WhatsApp Saat Ini</label>
                                    <input type="tel"
                                        class="form-control"
                                        value="{{ $user->phone }}"
                                        disabled>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Nomor ini sedang terdaftar pada akun Anda.
                                    </div>
                                </div>

                                {{-- Password saat ini --}}
                                <x-form.password
                                    name="current_password"
                                    label="Password Saat Ini"
                                    required
                                />

                                {{-- Nomor WhatsApp baru --}}
                                <x-form.input
                                    type="tel"
                                    name="phone"
                                    label="Nomor WhatsApp Baru"
                                    :value="old('phone', $user->phone)"
                                    placeholder="Contoh: 0812xxxxxxxx"
                                    required
                                />

                                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-whatsapp me-1"></i>
                                        Simpan & Kirim Verifikasi
                                    </button>

                                    @if(!$user->phone_verified_at)
                                        <small class="text-muted">
                                            Jika nomor tidak diubah, tombol ini akan mengirim ulang link verifikasi.
                                        </small>
                                    @else
                                        <small class="text-muted">
                                            Mengubah nomor akan membatalkan verifikasi lama dan mengirim link verifikasi baru.
                                        </small>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>



                    {{-- ========== SECTION: CHANGE EMAIL ========== --}}
                    <div id="section-email" class="card shadow border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-1">Ubah Alamat Email</h4>
                                    <p class="text-muted small mb-0">
                                        Perubahan email memerlukan password saat ini.
                                    </p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('email.change') }}" id="changeEmailForm">
                                @csrf

                                {{-- Email saat ini (readonly) --}}
                                <div class="mb-3 text-start">
                                    <label class="form-label">Email Saat Ini</label>
                                    <input type="email"
                                           class="form-control"
                                           value="{{ $user->email }}"
                                           disabled>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Email ini digunakan untuk login ke akun Anda.
                                    </div>
                                </div>

                                {{-- Password saat ini --}}
                                <x-form.password
                                    name="current_password"
                                    label="Password Saat Ini"
                                    required
                                >
                                    <x-slot name="help">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Diperlukan untuk mengkonfirmasi bahwa Anda pemilik akun.
                                    </x-slot>
                                </x-form.password>

                                {{-- Email baru --}}
                                <x-form.input
                                    type="email"
                                    name="new_email"
                                    label="Email Baru"
                                    :value="old('new_email')"
                                    placeholder="email-baru@contoh.com"
                                    required
                                >
                                    <x-slot name="help">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Email ini akan digunakan untuk login dan notifikasi.
                                    </x-slot>
                                </x-form.input>

                                {{-- Konfirmasi email baru --}}
                                <x-form.input
                                    type="email"
                                    name="new_email_confirmation"
                                    label="Konfirmasi Email Baru"
                                    :value="old('new_email_confirmation')"
                                    placeholder="Ketik ulang email baru"
                                    required
                                >
                                    <x-slot name="help">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Pastikan sama persis dengan email baru di atas.
                                    </x-slot>
                                </x-form.input>

                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <span>Update Email</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ========== SECTION: CHANGE PASSWORD ========== --}}
                    <div id="section-password" class="card shadow border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 class="mb-1">Ubah Password</h4>
                                    <p class="text-muted small mb-0">
                                        Gunakan password yang kuat untuk menjaga keamanan akun Anda.
                                    </p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('user.profile.password.update') }}" id="changePasswordForm">
                                @csrf

                                {{-- Password saat ini --}}
                                <x-form.password
                                    name="current_password"
                                    label="Password Saat Ini"
                                    required
                                >
                                    <x-slot name="help">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Diperlukan untuk memastikan bahwa Anda pemilik akun ini.
                                    </x-slot>
                                </x-form.password>

                                {{-- Password baru --}}
                                <x-form.password
                                    name="password"
                                    label="Password Baru"
                                    required
                                >
                                    <x-slot name="help">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Minimal 5 karakter, kombinasikan huruf dan angka.
                                    </x-slot>
                                </x-form.password>

                                {{-- Konfirmasi password baru --}}
                                <div class="mb-1 text-start">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password"
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                               required
                                               minlength="5">
                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                data-toggle="password"
                                                data-target="password_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <x-form.error name="password_confirmation" />
                                </div>
                                <div class="form-text mb-3">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Ketik ulang password baru Anda.
                                </div>

                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <span>Update Password</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="{{ asset('js/toggle-password.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const navButtons = document.querySelectorAll('#profile-settings-nav .nav-link');

                navButtons.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const targetSelector = this.getAttribute('data-scroll-target');
                        const targetEl = document.querySelector(targetSelector);

                        if (targetEl) {
                            window.scrollTo({
                                top: targetEl.offsetTop - 80,
                                behavior: 'smooth'
                            });
                        }

                        // set active state
                        navButtons.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            });
        </script>
    @endpush
</x-layout>
