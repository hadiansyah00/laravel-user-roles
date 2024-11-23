<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use PDF;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil daftar mata kuliah dari jadwal
        $mataKuliah = Jadwal::with('mataKuliah')->get();

        return view('laporan.index', [
            'mataKuliah' => $mataKuliah,
        ]);
    }

    public function generatePDF(Request $request)
    {
        // Validasi input
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
        ]);

        // Ambil data jadwal beserta relasi mata kuliah, absensi, dan mahasiswa
        $jadwal = Jadwal::with(['mataKuliah', 'absensi', 'mahasiswa'])->findOrFail($request->jadwal_id);

        // Ambil data mahasiswa terkait jadwal
        $mahasiswa = $jadwal->mahasiswa; // Pastikan relasi mahasiswa ada di model Jadwal


        // Rekap absensi per mahasiswa
        $rekapAbsensi = $jadwal->absensi()
            ->where('tanggal', '>=', Carbon::now('Asia/Jakarta')->subDays(14))
            ->orderBy('tanggal', 'asc')
            ->get()
            ->groupBy('mahasiswa_id');

        // Cek jika data absensi kosong
        if ($rekapAbsensi->isEmpty() || $mahasiswa->isEmpty()) {
            return redirect()->back()->with('error', 'Data absensi tidak tersedia untuk jadwal ini.');
        }

        // Generate PDF dengan orientasi Landscape
        $pdf = PDF::loadView('laporan.pdf', [
            'jadwal' => $jadwal,
            'mahasiswa' => $mahasiswa,
            'rekapAbsensi' => $rekapAbsensi,
        ])->setPaper('a4', 'landscape'); // Setel ukuran kertas A4 dan orientasi Landscape

        return $pdf->download('rekap-absensi-' . $jadwal->mataKuliah->nama . '.pdf');
    }
}
