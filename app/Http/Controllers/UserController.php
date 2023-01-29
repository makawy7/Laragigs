<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function login()
    {
        return view('user.login');
    }
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect()->intended()->with('message', 'You\'re now logged in!');
        } else {
            return back()->withErrors(['email' => 'Invalid Credentials!']);
        }
    }
    public function register()
    {
        return view('user.register');
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:8',
        ]);
        $formFields['password'] = Hash::make($request->password);
        $user = User::create($formFields);
        auth()->login($user);
        return redirect()->route('home')->with('message', 'User has been created.');
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        return redirect()->route('home')->with('message', 'You\'re logged out!');

    }
}
