<x-layout>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow border-0">
                    <div class="card-body p-4 text-center">
                        <i class="ri-key-2-fill text-primary fs-2"></i>
                        <h4 class="mt-2">Lupa Password</h4>
                        <p class="text-muted small">Masukkan Email yang terdaftar untuk mengganti password</p>

                        <x-alert type="error" />
                        <x-alert type="success" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <x-form.input type="email" name="email" label="Email" />

                            <div class="d-flex justify-content-center mt-4 mb-3">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ri-shield-keyhole-line me-2"></i>Reset
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <span class="text-muted">Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Masuk di sini</a>
                        </div>
                        <div class="text-center mt-2">
                            <span class="text-muted">Belum punya akun?</span>
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar di sini</a>
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
