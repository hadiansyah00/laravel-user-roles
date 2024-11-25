<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Setting;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

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
        $this->validateRequest($request);

        // Ambil jadwal dengan relasi
        $jadwal = $this->getJadwalWithRelations($request->jadwal_id, $request);

        // Tentukan rentang tanggal
        list($startDate, $endDate) = $this->determineDateRange($request);

        // Ambil total pertemuan dari mata kuliah terkait
        $totalPertemuan = $jadwal->mataKuliah->total_pertemuan;

        // Rekap absensi berdasarkan mahasiswa_id
        $rekapAbsensi = $this->rekapAbsensi($jadwal, $startDate, $endDate);

        // Pastikan mahasiswa tidak duplikat
        $mahasiswa = $this->getUniqueMahasiswa($jadwal);

        // Cek ketersediaan data
        $this->checkDataAvailability($rekapAbsensi, $mahasiswa);

        // Generate PDF
        return $this->generatePDFDocument($jadwal, $mahasiswa, $rekapAbsensi, $startDate, $endDate, $totalPertemuan);
    }


    // Validasi input dari request
    private function validateRequest(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,jadwal_id',
            'start_date' => 'nullable|date|before_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
    }

    // Ambil jadwal beserta relasinya
    private function getJadwalWithRelations($jadwalId, Request $request)
    {
        return Jadwal::with(['mataKuliah:matakuliah_id,name,total_pertemuan',
            'absensi' => function ($query) use ($request) {
                $startDate = $request->start_date ?? Carbon::now('Asia/Jakarta')->subDays(14);
                $endDate = $request->end_date ?? Carbon::now('Asia/Jakarta');
                $query->whereBetween('tanggal', [$startDate, $endDate])
                    ->select('absensi_id', 'jadwal_id', 'mahasiswa_id', 'tanggal', 'status');
            },
            'mahasiswa:mahasiswa_id,name',
        ])->findOrFail($jadwalId);
    }

    // Tentukan rentang tanggal untuk laporan
    private function determineDateRange(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now('Asia/Jakarta')->subDays(14);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now('Asia/Jakarta');
        return [$startDate, $endDate];
    }

private function rekapAbsensi($jadwal, $startDate, $endDate)
{
    // Retrieve attendance records based on schedule ID and the given date range
    $rekapAbsensi = $jadwal->absensi()
        ->whereBetween('tanggal', [$startDate, $endDate])
        ->orderBy('tanggal', 'asc')
        ->get()
        ->groupBy('mahasiswa_id'); // Group by mahasiswa_id

    // Transform attendance status into a more manageable format
    return $rekapAbsensi->map(function ($absensiRecords) {
        return $absensiRecords->map(function ($absensi) {
            return $this->mapAbsensiStatus($absensi->status);
        });
    });
}

private function mapAbsensiStatus($status)
{
    // Map attendance status to a concise format
    $statusMapping = [
        'hadir' => 'H',
        'tidak hadir' => 'T',
        'izin' => 'I',
        // Add more mappings if needed
    ];

    return $statusMapping[$status] ?? null; // Return null for unknown statuses
}

    // Ambil daftar mahasiswa yang unik (tanpa duplikat)
    private function getUniqueMahasiswa($jadwal)
    {
        return $jadwal->mahasiswa->unique('mahasiswa_id');
    }

    // Periksa apakah data absensi dan mahasiswa tersedia
    private function checkDataAvailability($rekapAbsensi, $mahasiswa)
    {
        if ($rekapAbsensi->isEmpty() || $mahasiswa->isEmpty()) {
            return redirect()->back()->with('error', 'Data absensi atau mahasiswa tidak tersedia.');
        }
    }
    public function generatePDFDocument($jadwal, $mahasiswa, $rekapAbsensi, $startDate, $endDate, $totalPertemuan)
    {
        $settings = Setting::first();
        $websiteUrl = $settings->website_url ?? 'https://example.com';

        // Generate QR code
        $qrCode = new QrCode($websiteUrl);
        $writer = new PngWriter();
        $qrCodeResult = $writer->write($qrCode);

        // Simpan QR code ke storage sementara
        $qrCodePath = 'temp/qr-code.png';
        Storage::put($qrCodePath, $qrCodeResult->getString());

        $rekap = [];
        foreach ($mahasiswa as $mhs) {
            $absensi = [];
            for ($i = 1; $i <= $totalPertemuan; $i++) {
                $status = $rekapAbsensi[$mhs->mahasiswa_id][$i - 1] ?? '-';
                $absensi[] = $status;
            }
            $rekap[] = [
                'nama' => $mhs->name,
                'absensi' => $absensi,
            ];
        }

        $logoBase64 = null;
        if ($settings && $settings->logo) {
            $logoPath = public_path('storage/' . $settings->logo);
            if (file_exists($logoPath)) {
                $logoBase64 = base64_encode(file_get_contents($logoPath));
            }
        }

        $pdf = PDF::loadView('laporan.pdf', [
            'jadwal' => $jadwal,
            'mahasiswa' => $mahasiswa,
            'rekapAbsensi' => $rekap,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalPertemuan' => $totalPertemuan,
            'settings' => $settings,
            'logoBase64' => $logoBase64,
            'qrCodePath' => Storage::url($qrCodePath), // URL ke QR code
        ])->setPaper('a4', 'landscape');

        $filename = 'rekap-absensi-' . $jadwal->mataKuliah->name . '-' . now()->format('YmdHis') . '.pdf';

        return $pdf->download($filename);
    }




}