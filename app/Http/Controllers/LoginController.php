<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = 'login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()
                ->withErrors(['email' => 'Terlalu banyak percobaan. Coba lagi dalam 1 menit.'])
                ->withInput();
        }

        if (! Auth::attempt($credentials)) {
            RateLimiter::hit($key, 60);
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();
        }

        if (! Auth::user()->is_active) {
            Auth::logout();
            return back()
                ->withErrors(['email' => 'Akun Anda dinonaktifkan, hubungi admin.'])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}