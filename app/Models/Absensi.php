<?php

namespace App\Models;

use App\Models\Jadwal;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'absensi';

    // Primary key
    protected $primaryKey = 'absensi_id';

    // Kolom yang bisa diisi
    protected $fillable = [
        'jadwal_id',
        'mahasiswa_id',
        'status',
        'keterangan',
        'tanggal',
    ];

    // Relasi ke model Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'jadwal_id');
    }

    // Relasi ke model Siswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}
