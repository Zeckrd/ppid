<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

        public function store()
    {
        //validate
        $attributes = request()->validate([
            'email'=>['required','email'],
            'password'=>['required']
        ]);

        //attempt login user
        if (! Auth::attempt($attributes)){
            throw ValidationException::withMessages([
                'credential' => 'Email atau Password salah'
            ]);
        };

        //if succedd regenerate session token
        request()->session()->regenerate();

        //redirect
        return redirect('/jobs');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/');
    }
}
