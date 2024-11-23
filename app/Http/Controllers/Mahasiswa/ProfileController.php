<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $mahasiswa = auth('mahasiswa')->user();
        return view('mhs.profile', ['mahasiswa' => $mahasiswa]);
    }

    public function update(Request $request)
    {
        $mahasiswa = auth('mahasiswa')->user();

        $this->validateRequest($request, $mahasiswa);

        $this->updateMahasiswa($mahasiswa, $request);

        return redirect()->route('mahasiswa.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    protected function validateRequest(Request $request, $mahasiswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,
            'password' => 'nullable|min:6|confirmed',
        ]);
    }

    protected function updateMahasiswa($mahasiswa, Request $request)
    {
        $mahasiswa->name = $request->name;
        $mahasiswa->email = $request->email;

        if ($request->filled('password')) {
            $mahasiswa->password = Hash::make($request->password);
        }

        $mahasiswa->save();
    }
}