<x-layout>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            {{-- Make sure the column is wide enough for reCAPTCHA on all breakpoints --}}
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card shadow border-0">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-box-arrow-in-right text-primary fs-2"></i>
                        <h4 class="mt-2">Log In</h4>
                        <p class="text-muted small">Masuk ke akun Anda untuk membuat permohonan informasi</p>

                        <x-alert type="error" />
                        <x-alert type="success" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <x-form.input type="email" name="email" label="Email" />
                            <x-form.password name="password" label="Password" />

                            <div class="d-flex justify-content-center mt-4 mb-3">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="text-decoration-none d-block mb-2">
                                Lupa Password?
                            </a>
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
