<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Jadwal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = auth('mahasiswa')->user();

        // Data jadwal kuliah hari ini
        $jadwalHariIni = Jadwal::where('program_studi_id', $mahasiswa->program_studi_id)
        ->get();

        $totalKetidakhadiran = Absensi::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->where('status', 'tidak hadir')
            ->count();

        $totalJadwal = Jadwal::where('program_studi_id', $mahasiswa->program_studi_id)
            ->count();

        // Check if totalJadwal is greater than 0 to avoid division by zero
        // if ($totalJadwal > 0) {
        //     $persentaseKehadiran = round(($totalKehadiran / $totalJadwal) * 100, 2);
        // } else {
        //     $persentaseKehadiran = 0; // Set to 0 if no classes are scheduled
        // }
        // Jadwal Berikutnya
        $jadwalBerikutnya = Jadwal::where('program_studi_id', $mahasiswa->program_studi_id)
            ->whereDate('tanggal', Carbon::today())
            ->where('jam_mulai', '>', Carbon::now()->format('H:i:s'))
            ->orderBy('jam_mulai', 'asc')
            ->first();

        // Tanggal Sekarang
        $tanggalSekarang = Carbon::now()->translatedFormat('l, d F Y');

        // Return view dengan data lengkap
        return view('mhs.dashboard', compact(
            'jadwalHariIni',
            'totalKetidakhadiran',
            'jadwalBerikutnya',
            'tanggalSekarang',
            'totalJadwal'
        ));
    }
}