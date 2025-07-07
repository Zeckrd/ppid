<x-layout>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center py-4">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-plus text-primary" style="font-size: 2rem;"></i>
                            <h4 class="card-title mt-2">Buat Akun Baru</h4>
                            <p class="text-muted small">Daftar untuk membuat permohonan informasi secara online</p>
                        </div>

                        {{-- Display validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
                            @csrf
                            
                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autocomplete="name"
                                       autofocus
                                       placeholder="Masukkan nama lengkap Anda">
                                <x-form-error name='name'></x-form-error>
                            </div>
                           
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
                                       placeholder="contoh@email.com">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Email akan digunakan untuk verifikasi akun
                                </div>
                                <x-form-error name='email'></x-form-error>
                            </div>
                           
                            {{-- Phone --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text">+</span>
                                    <input type="tel" 
                                           name="phone" 
                                           id="phone" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone') }}" 
                                           required 
                                           autocomplete="tel"
                                           placeholder="628123456789"
                                           pattern="[0-9]{8,15}">
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Gunakan format: 628123456789 (tanpa spasi atau tanda hubung)
                                </div>
                                <x-form-error name='phone'></x-form-error>
                            </div>
                           
                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           required 
                                           autocomplete="new-password"
                                           minlength="5">
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            id="togglePassword"
                                            onclick="togglePasswordVisibility('password', 'togglePasswordIcon')">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Minimal 5 karakter, kombinasi huruf, angka, dan simbol
                                </div>
                                <x-form-error name='password'></x-form-error>
                            </div>
                           
                            {{-- Password Confirmation --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation" 
                                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           required 
                                           autocomplete="new-password"
                                           minlength="5">
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            id="togglePasswordConfirmation"
                                            onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordConfirmationIcon')">
                                        <i class="bi bi-eye" id="togglePasswordConfirmationIcon"></i>
                                    </button>
                                </div>
                                <div id="passwordMatch" class="form-text"></div>
                                <x-form-error name='password_confirmation'></x-form-error>
                            </div>
                           
                            {{-- Submit --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-person-plus me-2"></i>
                                    <span id="submitText">Daftar Sekarang</span>
                                </button>
                            </div>
                        </form>
                           
                        {{-- Login Link --}}
                        <div class="text-center">
                            <span class="text-muted">Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                Masuk di sini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for enhanced UX --}}
    <script>
        // Password visibility toggle
        function togglePasswordVisibility(fieldId, iconId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }

        // Password confirmation matching
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            const passwordMatch = document.getElementById('passwordMatch');
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');

            function checkPasswordMatch() {
                if (passwordConfirmation.value === '') {
                    passwordMatch.textContent = '';
                    passwordMatch.className = 'form-text';
                } else if (password.value === passwordConfirmation.value) {
                    passwordMatch.textContent = '✓ Password cocok';
                    passwordMatch.className = 'form-text text-success';
                } else {
                    passwordMatch.textContent = '✗ Password tidak cocok';
                    passwordMatch.className = 'form-text text-danger';
                }
            }

            password.addEventListener('input', checkPasswordMatch);
            passwordConfirmation.addEventListener('input', checkPasswordMatch);

            // Form submission handling
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mendaftar...';
                
                // Re-enable after 15 seconds as fallback
                setTimeout(function() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-person-plus me-2"></i>Daftar Sekarang';
                }, 15000);
            });

        });
    </script>
</x-layout>