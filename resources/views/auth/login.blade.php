<x-layout>
    <form method="POST" action="{{ route('login') }}">
    @csrf
    
    @if($errors->has('phone'))
        <div class="alert alert-warning position-fixed top-0 start-50 translate-middle-x mt-5 pt-5 z-1050" style="min-width: 300px;">
            {{ $errors->first('phone') }}
        </div>
    @endif

    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center position-relative">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-4">Log In</h4>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                                <x-form-error name='email'></x-form-error>
                            </div>
                            
                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <x-form-error name='password'></x-form-error>
                            </div>
                            
                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Log In</button>
                            </div>
                        </form>

                        {{-- Register Link --}}
                        <div class="text-center mt-3">
                            <p class="mb-0">Belum Punya akun? <a href="/register" class='text-decoration-none fw-bold'>Registrasi di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
</x-layout>