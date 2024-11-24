<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()

    {
        $jumlahMahasiswa = Mahasiswa::count();
        $jumlahProgramStudi = ProgramStudi::count();
        $jadwal = Jadwal::latest()->take(5)->get(); // Ambil 5 jadwal terbaru
        $absensi = Absensi::latest()->take(5)->get(); // Ambil 5 data absensi terbaru

        return view('home', compact('jumlahMahasiswa', 'jumlahProgramStudi', 'jadwal', 'absensi'));
    }

}
