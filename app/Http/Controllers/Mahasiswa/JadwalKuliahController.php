<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JadwalKuliahController extends Controller
{
    public function index()
    {
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Ambil jadwal berdasarkan program studi mahasiswa
        $jadwalKuliah = Jadwal::where('program_studi_id', $mahasiswa->program_studi_id)
            ->orderBy('hari', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('mhs.jadwal.index', compact('jadwalKuliah'));
    }
}
