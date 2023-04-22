<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function login()
    {
        validator(request()->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();

        if (auth()->attempt(request()->only('email', 'password'))) {
            return redirect('/dashboard');
        }

        return redirect()->back()->withErrors(['credentials' => 'invalid credentials']);
    }
}
