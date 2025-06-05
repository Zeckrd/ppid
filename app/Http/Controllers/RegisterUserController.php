<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        // debug this
        // dd(request()->all());

        $attributes = request()->validate([
            'name'          => ['required'],
            'email'         => ['required', 'unique:users,email'],
            'password'      => ['required', Password::min(5)->letters(),'confirmed'],
            'pekerjaan'     => ['required'],
            'ktp_no'        => ['required'],
            'ktp_foto'      => ['required', 'image', 'max:2048'],
            'alamat'        => ['required'],

        ]);

        $attributes['ktp_foto'] = request()->file('ktp_foto')->store('ktp_fotos', 'public');

        $user = User::create($attributes);

        Auth::login($user);

        return redirect('dashboard');
    }
}
