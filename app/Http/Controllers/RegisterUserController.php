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
        ]);

        //create User
        $user = User::create($attributes);

        // Login User
        Auth::login($user);

        // redirect
        return redirect('dashboard');
    }
}
