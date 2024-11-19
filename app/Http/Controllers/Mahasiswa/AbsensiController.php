<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Jadwal;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AbsensiController extends Controller
{
    // Menampilkan halaman absensi untuk mahasiswa berdasarkan jadwal
    public function index($jadwalId)
    {
        // Mengambil data jadwal berdasarkan jadwalId
        $jadwal = Jadwal::with('mataKuliah')->findOrFail($jadwalId);

        // Mengambil data mahasiswa yang sedang login
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Mengecek apakah mahasiswa sudah absen untuk jadwal tersebut
        $absensi = Absensi::where('jadwal_id', $jadwalId)
            ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->first();

        // Menampilkan view absensi dengan data jadwal, mahasiswa dan absensi
        return view('mhs.absensi', compact('jadwal', 'mahasiswa', 'absensi'));
    }

    // Menyimpan data absensi
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
            'mahasiswa_id' => 'required|exists:mahasiswa,mahasiswa_id',
            'status' => 'required|in:hadir,tidak hadir,izin',
        ]);

        // Simpan atau perbarui data absensi mahasiswa
        Absensi::updateOrCreate(
            [
                'jadwal_id' => $request->jadwal_id,
                'mahasiswa_id' => $request->mahasiswa_id,
                'tanggal' => now()->toDateString(), // Menggunakan tanggal hari ini
            ],
            [
                'status' => $request->status,
                'keterangan' => $request->keterangan,
            ]
        );

        // Mengarahkan kembali dengan pesan sukses
        return back()->with('success', 'Absensi berhasil diperbarui.');
    }
}
