<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Jadwal;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        ->where('mahasiswa_id', $mahasiswa->mahasiswa_id) // Periksa properti `id` atau gunakan `mahasiswa_id` sesuai database
            ->whereDate('tanggal', Carbon::now('Asia/Jakarta'))
            ->exists();

        // Mengambil riwayat absensi berdasarkan jadwal dan mahasiswa
        $riwayatAbsensi = Absensi::where('jadwal_id', $jadwalId)
        ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->orderBy('created_at', 'desc')
            ->get();


        Carbon::setLocale('id');

        // Menampilkan view absensi dengan data jadwal, mahasiswa, absensi, dan riwayatAbsensi
        return view('mhs.absensi', [
            'jadwal' => $jadwal,
            'mahasiswa' => $mahasiswa,
            'absensi' => $absensi,
            'riwayatAbsensi' => $riwayatAbsensi,
        ]);
    }

    // Menyimpan data absensi
    // public function show(Jadwal $jadwal)
    // {
    //     $mahasiswa = Auth::guard('mahasiswa')->user();
    //     $riwayatAbsensi = Absensi::where('jadwal_id', $jadwal->id)
    //         ->where('mahasiswa_id', $mahasiswa->id)
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return view('mhs.absensi', compact(
    //         'jadwal',
    //         'mahasiswa',
    //         'riwayatAbsensi'
    //     ));
    // }



    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
            'mahasiswa_id' => 'required|exists:mahasiswa,mahasiswa_id',
            'status' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Periksa apakah mahasiswa sudah absen pada jadwal dan hari yang sama
        $hasAbsensiToday = Absensi::where('jadwal_id', $validatedData['jadwal_id'])
        ->where('mahasiswa_id', $validatedData['mahasiswa_id'])
        ->whereDate(
            'tanggal',
            Carbon::now('Asia/Jakarta')
        )
        ->exists();

        if ($hasAbsensiToday) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        // Simpan absensi jika belum ada
        Absensi::create([
            'jadwal_id' => $validatedData['jadwal_id'],
            'mahasiswa_id' => $validatedData['mahasiswa_id'],
            'status' => $validatedData['status'],
            'keterangan' => $validatedData['keterangan'],
            'tanggal' => now('Asia/Jakarta'),
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil dikirim.');
    }


}
