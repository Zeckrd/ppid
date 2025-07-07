<x-layout>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center position-relative">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-4">Reset Password</h4>
                        
                        {{-- error checks --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Display email --}}
                        <div class="mb-3">
                            <p class="text-muted small mb-0">Reset password untuk:</p>
                            <p class="fw-bold mb-0">{{ $email }}</p>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            
                            {{-- Hidden --}}
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">
                            
                            {{-- New Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       required 
                                       minlength="8"
                                       autocomplete="new-password">
                                <div class="form-text">
                                    Password minimal 5 karakter
                                </div>
                                <x-form-error name='password'></x-form-error>
                            </div>
                            
                            {{-- Password Confirmation --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       required 
                                       minlength="8"
                                       autocomplete="new-password">
                                <x-form-error name='password_confirmation'></x-form-error>
                            </div>
                            
                            {{-- Submit --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-shield-lock me-2"></i>Reset Password
                                </button>
                            </div>
                        </form>
                        
                        {{-- Back to Login Link --}}
                        <div class="text-center mt-3">
                            <p class="mb-0">
                                <a href="{{ route('login') }}" class='text-decoration-none'>
                                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>