<x-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100 justify-content-center">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">
                            <h4 class="card-title text-center mb-4">Registrasi</h4>

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                <x-form-error name='name'></x-form-error>
                            </div>
                            
                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                                <x-form-error name='email'></x-form-error>
                            </div>
                            
                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <x-form-error name='password'></x-form-error>
                            </div>
                            
                            {{-- Password Confirmation --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Ketik Ulang Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <x-form-error name='password_confirmation'></x-form-error>
                            </div>
                            
                            {{-- Phone --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Whatsapp</label>
                                <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="62..." required>
                                <x-form-error name='phone'></x-form-error>
                            </div>
                            
                            {{-- Submit --}}
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                            
                            {{-- Login Link --}}
                            <div class="text-center">
                                <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login di sini</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout>
