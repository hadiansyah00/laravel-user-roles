<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Absensi;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;
use Illuminate\Http\Request;
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

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil dibuka');
    }

    // Method untuk menutup absensi
    public function closeAbsensi($jadwalId)
    {
        $jadwal = Jadwal::findOrFail($jadwalId);
        $jadwal->status_absensi = false; // Mengubah status menjadi tertutup
        $jadwal->save();

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil ditutup');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function tutupSesiAbsensi($jadwalId)
    {
        // Temukan jadwal berdasarkan ID
        $jadwal = Jadwal::findOrFail($jadwalId);

        // Set status_absensi menjadi 0 (tutup)
        $jadwal->status_absensi = 0;
        $jadwal->save();

        return redirect()->route('admin.absensi.detail', $jadwalId)
            ->with('success', 'Sesi absensi telah ditutup.');
    }

    // Fungsi untuk membuka sesi absensi
    public function bukaSesiAbsensi($jadwalId)
    {
        // Temukan jadwal berdasarkan ID
        $jadwal = Jadwal::findOrFail($jadwalId);

        // Set status_absensi menjadi 1 (aktif)
        $jadwal->status_absensi = 1;
        $jadwal->save();

        return redirect()->route('admin.absensi.detail', $jadwalId)
            ->with('success', 'Sesi absensi telah dibuka.');
    }
    public function updateStatus($absensiId, Request $request)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:hadir,tidak hadir,sakit',
        ]);

        // Temukan absensi berdasarkan ID
        $absensi = Absensi::findOrFail($absensiId);

        // Update status kehadiran mahasiswa
        $absensi->status = $request->status;
        $absensi->save();

        return redirect()->route('admin.absensi.detail', $absensi->jadwal_id)
            ->with('success', 'Status kehadiran berhasil diperbarui.');
    }
    public function riwayat(Request $request)
    {
        // Deklarasi variabel untuk tabel kosong secara default
        $riwayat = collect();
        $tanggal = $request->tanggal ?? null;

        // Jika tanggal dipilih, proses data absensi
        if ($tanggal) {
            // Validasi tanggal
            $request->validate([
                'tanggal' => 'required|date',
            ]);

            // Ambil data absensi berdasarkan tanggal dan group per mahasiswa
            $riwayat = Absensi::where('tanggal', $tanggal)
                ->with('mahasiswa') // Relasi dengan mahasiswa
                ->get()
                ->groupBy('mahasiswa_id');
        }

        // Tampilkan view dengan data riwayat absensi
        return view('absensi.detail', [
            'riwayat' => $riwayat,
            'tanggal' => $tanggal
        ]);
    }

    public function show($jadwal_id)
    {
        // Ambil data jadwal berdasarkan jadwal_id
        $jadwal = Jadwal::findOrFail($jadwal_id);

        // Ambil data absensi yang terkait dengan jadwal tersebut
        $absensi = Absensi::where('jadwal_id', $jadwal_id)->get();

        // Kirim data ke view
        return view('absensi.show', compact(
            'jadwal',
            'absensi'
        ));
    }
}