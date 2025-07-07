<x-layout>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center position-relative">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-box-arrow-in-right text-primary" style="font-size: 2rem;"></i>
                            <h4 class="card-title mt-2">Log In</h4>
                            <p class="text-muted small">Masuk ke akun Anda untuk membuat permohonan informasi</p>
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

                        {{-- Success message (if redirected from registration) --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}"
                                       required 
                                       autocomplete="email"
                                       autofocus>
                                <x-form-error name='email'></x-form-error>
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
                                           autocomplete="current-password">
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            id="togglePassword"
                                            onclick="togglePasswordVisibility()">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <x-form-error name='password'></x-form-error>
                            </div>
                           
                            {{-- Submit --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                </button>
                            </div>
                        </form>
                        
                        {{-- Links --}}
                        <div class="text-center">
                            <div class="mb-2">
                                <a href="{{ route('password.request') }}" class='text-decoration-none'>
                                    <i class="bi bi-key me-1"></i>Lupa Password?
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

    {{-- JavaScript for password toggle --}}
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
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
    </script>
</x-layout>