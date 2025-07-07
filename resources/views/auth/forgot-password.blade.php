<x-layout>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center position-relative">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-key text-primary" style="font-size: 2rem;"></i>
                            <h4 class="card-title mt-2">Lupa Password</h4>
                            <p class="text-muted small">
                                Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password
                            </p>
                        </div>

                        {{-- Display validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Success message --}}
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}"
                                       required 
                                       autocomplete="email"
                                       autofocus
                                       placeholder="contoh@email.com">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Pastikan email yang Anda masukkan terdaftar di sistem
                                </div>
                                <x-form-error name='email'></x-form-error>
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-envelope me-2"></i>
                                    <span id="submitText">Kirim Link Reset</span>
                                </button>
                            </div>
                        </form>

                        {{-- Login/Daftar Nav --}}
                        <div class="text-center">
                            <div class="mb-2">
                                <a href="{{ route('login') }}" class='text-decoration-none'>
                                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                                </a>
                            </div>
                            <div>
                                <span class="text-muted">Belum punya akun?</span>
                                <a href="{{ route('register') }}" class='text-decoration-none fw-bold'>
                                    Daftar di sini
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for better UX --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            
            form.addEventListener('submit', function() {
                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim...';
                
                // Re-enable after 10 seconds as fallback
                setTimeout(function() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-envelope me-2"></i>Kirim Link Reset';
                }, 10000);
            });
        });
    </script>
</x-layout>