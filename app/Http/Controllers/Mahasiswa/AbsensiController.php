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
            ->where('mahasiswa_id', $mahasiswa->id) // Pastikan properti `id` di Mahasiswa sesuai
            ->first();

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
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
            'mahasiswa_id' => 'required|exists:mahasiswa,mahasiswa_id',
            'status' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Absensi::create([
            'jadwal_id' => $request->jadwal_id,
            'mahasiswa_id' => $request->mahasiswa_id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'tanggal' => now()->addHours(7)->timezone('Asia/Jakarta')->toDateTimeString(),
        ]);

        return redirect()->back()->with('success', 'Absensi berhasil dsikirim.');
    }
}
