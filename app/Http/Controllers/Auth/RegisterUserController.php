<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\PhoneVerification;


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

        // Normaliza phone number
        $phoneRaw = request()->input('phone', '');

        $phone = preg_replace('/[^0-9]/', '', $phoneRaw);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        request()->merge(['phone' => $phone]);

        $attributes = request()->validate([
            'name'          => ['required'],
            'pekerjaan'     => ['required'],
            'email'         => ['required', 'unique:users,email'],
            'password'      => ['required', Password::min(5)->letters(),'confirmed'],
            'phone'         => ['required', 'unique:users,phone']
        ]);

        //create User
        $user = User::create($attributes);

         // Str to generate token example: "20a5d4cb-8b12-48c6-a0b2-e4e39d01e3b5"
        $token = Str::uuid();

        //store token in prone verification table with associated user id
        PhoneVerification::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        //use token to generate link, send with message to Services/WablasService.php
        $verifyUrl = route('verify.phone', ['token' => $token]);
        $message = "Halo {$user->name}, klik link ini untuk verifikasi nomor Anda: $verifyUrl";
        app(\App\Services\WablasService::class)->sendMessage($user->phone, $message);

        // Login User
        Auth::login($user);

        // redirect
        return redirect('dashboard');
    }
}
