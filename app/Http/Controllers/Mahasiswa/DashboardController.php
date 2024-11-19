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

        // Statistik kehadiran
        $statistik = Absensi::where('mahasiswa_id', $mahasiswa->id)
            ->selectRaw('
                SUM(CASE WHEN status = "Hadir" THEN 1 ELSE 0 END) as hadir,
                SUM(CASE WHEN status = "Izin" THEN 1 ELSE 0 END) as izin,
                SUM(CASE WHEN status = "Sakit" THEN 1 ELSE 0 END) as sakit,
                SUM(CASE WHEN status = "Tidak Hadir" THEN 1 ELSE 0 END) as tidak_hadir
            ')
            ->first();

        return view('mhs.dashboard', compact('jadwalHariIni', 'statistik'));
    }
}
