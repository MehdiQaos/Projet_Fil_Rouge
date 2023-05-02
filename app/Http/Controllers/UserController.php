<?php

namespace App\Http\Controllers;

use App\Models\Gametype;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login()
    {
        return view('users.login');
    }

    public function create()
    {
        return view('users.signup');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $formFields = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'user_name' => ['required', 'min:7', Rule::unique('users')->ignore($user->user_name, 'user_name')],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->email, 'email')],
        ]);

        $user->update($formFields);
        return redirect('/profile')->with('message', 'Profile updated successfully');
    }

    public function password(Request $request)
    {
        $user = auth()->user();
        $formFields = $request->validate([
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $password = Hash::make($formFields['password']);

        $user->update([
            'password' => $password
        ]);
        return redirect('/profile')->with('message', 'Profile updated successfully');
    }

    public function users()
    {
        $users = User::all();
        return view('users', [
            'users' => $users,
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect('/users');
    }
}
