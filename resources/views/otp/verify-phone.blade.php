<x-layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if(session('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4>Verifikasi Nomor Telepon</h4>
                    </div>

                    <div class="card-body">

                        {{-- Step 1: Masukkan nomor telepon --}}
                        <form method="POST" action="{{ route('verify-phone.send') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 6281234567890" required>
                                @error('phone')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Kirim OTP</button>
                        </form>

                        <hr>

                        {{-- Step 2: Masukkan kode OTP --}}
                        <form method="POST" action="{{ route('verify-phone.confirm') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="otp" class="form-label">Kode OTP</label>
                                <input type="text" class="form-control" name="otp" placeholder="Masukkan OTP yang dikirim" required>
                                @error('otp')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success w-100">Verifikasi OTP</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>