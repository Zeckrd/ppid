<x-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100 justify-content-center">
                <div class="col-8 col-md-8 col-lg-8 col-xl-3">
                    <div class="card shadow py-3 px-2">
                        <div class="division mb-3">
                            <div class="row justify-content-center">
                                <div class="col-auto text-center">
                                    <h4>Registrasi Pengguna</h4>
                                </div>
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
                            <x-form-input name="phone" id="phone" :value="old('phone')" placeholder="Nomor Telpon 62"  required></x-form-input>
                            <x-form-error name='phone'></x-form-error>
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
