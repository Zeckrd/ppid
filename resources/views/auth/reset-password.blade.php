<x-layout>
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow border-0">
                    <div class="card-body p-4 text-center">
                        <i class="ri-key-2-fill text-primary fs-2"></i>
                        <h4 class="mt-2">Atur Ulang Password</h4>

                        <x-alert type="error" />
                        <x-alert type="success" />

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">

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
                            <div class="form-text text-start">
                                <i class="bi bi-info-circle me-1"></i>Ketik ulang password
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3">
                                <i class="ri-shield-keyhole-line me-2"></i>Reset
                            </button>
                        </form>
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
