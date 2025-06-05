<x-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100 justify-content-center">
                <div class="col-12 col-md-8 col-lg-3 col-xl-3">
                    <div class="card no-hover py-3 px-2">
                        <div class="division mb-3">
                            <div class="row">
                                <div class="col-3"><div class="line l"></div></div>
                                <div class="col-6 text-center"><span>Registrasi Pengguna</span></div>
                                <div class="col-3"><div class="line r"></div></div>
                            </div>
                        </div>

                        {{-- Registration Form --}}
                        <x-form-field>
                            <x-form-input name="name" id="name" type="text" :value="old('name')" placeholder="Nama Lengkap"  required></x-form-input>
                            <x-form-error name='name'></x-form-error>
                        </x-form-field>

                        <x-form-field>
                            <x-form-input name="email" type="email" placeholder="Email" required />
                            <x-form-error name='email'></x-form-error>
                        </x-form-field>

                        <x-form-field>
                            <x-form-input name="password" id="password" type="password" :value="old('password')" placeholder="Password"  required></x-form-input>
                            <x-form-error name='password'></x-form-error>
                        </x-form-field>

                        <x-form-field>
                            <x-form-input name="password_confirmation" id="password_confirmation" type="password" :value="old('password_confirmation')" placeholder="Ketik Ulang Password"  required></x-form-input>
                            <x-form-error name='password_confirmation'></x-form-error>
                        </x-form-field>

                        <x-form-field>
                            <x-form-input name="pekerjaan" id="pekerjaan" type="text" :value="old('pekerjaan')" placeholder="Pekerjaan"  required></x-form-input>
                            <x-form-error name='pekerjaan'></x-form-error>
                        </x-form-field>

                        <x-form-field>
                            <x-form-input name="ktp_no" id="ktp_no" type="text" :value="old('ktp_no')" placeholder="Nomor KTP"  required></x-form-input>
                            <x-form-error name='ktp_no'></x-form-error>
                        </x-form-field>

                        <x-form-field>
                            <label for="ktp_foto" class="form-label ps-4">Upload Foto KTP</label>
                            <x-form-input name="ktp_foto" id="ktp_foto" type="file" accept='image/*' required></x-form-input>
                            <x-form-error name='ktp_foto'></x-form-error>
                        </x-form-field>

                        <x-form-field>
                            <x-form-input name="alamat" id="alamat" type="text" :value="old('alamat')" placeholder="Alamat"  required></x-form-input>
                            <x-form-error name='alamat'></x-form-error>
                        </x-form-field>

                        <div class="form-group mt-3">
                            <x-form-button>Daftar</x-form-button>
                        </div>

                        <div class="text-center mt-2">
                            <small>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-layout>
