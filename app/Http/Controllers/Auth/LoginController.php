<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan view login ada di resources/views/auth/login.blade.php
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Autentikasi dengan guard web
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Jika berhasil, arahkan ke halaman home admin
            return redirect()->intended(route('admin.home'));
        }

        // Jika gagal login, kembali dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login'); // Arahkan kembali ke form login
    }
}