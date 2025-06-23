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
            <div class="col-8 col-md-8 col-lg-8 col-xl-3">
                <div class="card shadow py-3 px-2">
                    <div class="division mb-3">
                        <div class="row justify-content-center">
                            <div class="col-auto text-center">
                                <h4>Login</h4>
                            </div>
                        </div>
                    </div>
                    <x-form-field>
                        <x-form-input name="email" id="email" type="email" :value="old('email')" placeholder="Email"  required></x-form-input>

                        <x-form-input name="password" id="password" type="password" :value="old('password')" placeholder="Password"  required></x-form-input>

                        <div class="ps-4">
                            <x-form-error name='credential'></x-form-error>
                        </div>
                        
                        <div class="row my-2 px-4">
                            <div class="col-md-6 col-12">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Ingat Saya</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 bn text-end">Lupa Password</div>
                        </div>
                        <div class="form-group mt-3">
                            <x-form-button>Log in</x-form-button>
                        </div>
                        <div class="text-center mt-2">
                            <small>Belum memiliki akun? <a href="{{ route('register') }}">Registrasi di sini</a></small>
                        </div>
                    </x-form-field>
                </div>
            </div>
        </div>
    </div>

</form>
</x-layout>