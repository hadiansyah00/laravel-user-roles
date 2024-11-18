<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class MahasiswaLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.mahasiswa-login');
    }

    public function login(Request $request)
    {
        // Validate input: email or NIM and password are required
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Determine if the input is an email or NIM
        $fieldType = $this->getFieldType($request->email);

        // Attempt to log in based on the determined field type
        if (Auth::guard('mahasiswa')->attempt([$fieldType => $request->email, 'password' => $request->password])) {
            return redirect()->route('mahasiswa.dashboard');
        }

        // If authentication fails, return with an error message
        return back()->withErrors([
            'credentials' => 'NIM atau email, atau password salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Determine if the input is an email or NIM.
     *
     * @param string $input
     * @return string
     */
    private function getFieldType(string $input): string
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';
    }
    public function logout()
    {
        Auth::guard('mahasiswa')->logout();
        return redirect()->route('mahasiswa.login');
    }
}
