<x-layout>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center py-4">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-plus text-primary fs-2"></i>
                            <h4 class="mt-2">Buat Akun Baru</h4>
                            <p class="text-muted small">Daftar untuk membuat permohonan informasi secara online</p>
                        </div>

                        <x-alert type="error" />
                        <x-alert type="success" />

                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
                            @csrf

                            <x-form.input name="name" label="Nama Lengkap" placeholder="Masukkan nama lengkap Anda" required />
                            <x-form.input type="email" name="email" label="Alamat Email" placeholder="contoh@email.com" required>
                                <x-slot name="help">
                                    <i class="bi bi-info-circle me-1"></i>Email akan digunakan untuk login akun
                                </x-slot>
                            </x-form.input>

                            <x-form.phone />

                            <x-form.password name="password" label="Password" help="Minimal 5 karakter, kombinasi huruf, angka, dan simbol" />

                            <div class="mb-1 text-start">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
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
                                <div id="passwordMatch" class="form-text"></div>
                                <x-form.error name="password_confirmation" />
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>Ketik ulang password
                            </div>

                            <div class="d-flex justify-content-center mt-4 mb-3">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-person-plus me-2"></i>
                                    <span>Daftar Sekarang</span>
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <span class="text-muted">Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Masuk di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script async src="https://www.google.com/recaptcha/api.js"></script>
        <script src="{{ asset('js/toggle-password.js') }}"></script>
    @endpush
</x-layout>
