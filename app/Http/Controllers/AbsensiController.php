<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Absensi;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Menampilkan daftar jadwal
    public function index(): View
    {
        $jadwal = Jadwal::with('mataKuliah')->paginate(10);

        $now = Carbon::now(); // Ambil waktu saat ini

        // Menambahkan flag untuk menandakan apakah absensi bisa dibuka
        foreach ($jadwal as $item) {
            $startTime = Carbon::parse($item->jam_mulai); // Waktu mulai dari jadwal
            $item->can_attend = $now->greaterThanOrEqualTo($startTime); // Jika waktu sekarang >= jam mulai
        }

        return view('absensi.index', compact('jadwal'));
    }
    // Menampilkan detail absensi berdasarkan jadwal
    public function detail($jadwalId): View
    {
        $jadwal = Jadwal::with('mataKuliah')->findOrFail($jadwalId);
        $absensi = Absensi::with('mahasiswa')
            ->where('jadwal_id', $jadwalId)
            ->get();

        // Mengambil riwayat absensi berdasarkan mahasiswa untuk jadwal tertentu
        $riwayat = Absensi::with('mahasiswa')
            ->where('jadwal_id', $jadwalId)
            ->select('mahasiswa_id', 'status', 'tanggal')
            ->orderBy('mahasiswa_id')
            ->orderBy('tanggal')
            ->get()
            ->groupBy('mahasiswa_id');

        return view('absensi.detail', compact('jadwal', 'absensi', 'riwayat'));
    }

    public function openAbsensi($jadwalId)
    {
        $jadwal = Jadwal::findOrFail($jadwalId);
        $jadwal->status_absensi = true; // Mengubah status menjadi terbuka
        $jadwal->save();

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil dibuka');
    }

    // Method untuk menutup absensi
    public function closeAbsensi($jadwalId)
    {
        $jadwal = Jadwal::findOrFail($jadwalId);
        $jadwal->status_absensi = false; // Mengubah status menjadi tertutup
        $jadwal->save();

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil ditutup');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbsensiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbsensiRequest $request, Absensi $absensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi)
    {
        //
    }
}
