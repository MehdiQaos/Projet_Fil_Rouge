<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // public function login()
    // {
    //     validator(request()->all(), [
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ])->validate();

    //     if (auth()->attempt(request()->only('email', 'password'))) {
    //         return redirect('/dashboard');
    //     }

    //     return redirect()->back()->withErrors(['credentials' => 'invalid credentials']);
    // }

    // public function register()
    // {
    // }

    // Create New User
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'first_name' => ['required', 'min:3'],
            'last_name' => ['required', 'min:3'],
            'user_name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $formFields['password'] = Hash::make($formFields['password']);
        $formFields['role_id'] = 2;

        $user = User::create($formFields);
        Rating::makeRatings($user);

        auth()->login($user);

        return redirect('/')->with('message', 'Registerd and logged in with success');
    }

    // Logout User
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'logged out');
    }

    // Authenticate User
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'logged in with success');
        }

        return back()->withErrors(['email' => 'invalid credentials'])->onlyInput('email');
    }
}
