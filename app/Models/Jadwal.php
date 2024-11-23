<?php

namespace App\Models;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Jadwal extends Model
{

    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'jadwal_id';
    protected $fillable = [
        'user_id',
        'program_studi_id',
        'mata_kuliah_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'status_absensi',
    ];


    // Relasi ke model MataKuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matakuliah_id', 'matakuliah_id');
    }

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke model ProgramStudi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'program_studi_id');
    }

    // Relasi ke model Absensi
public function absensi()
{
    return $this->hasMany(Absensi::class, 'jadwal_id');
}


    // Relasi ke model Mahasiswa melalui tabel pivot Absensi
    public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'absensi',         // Tabel pivot
            'jadwal_id',       // Foreign key di tabel pivot (mengarah ke tabel ini)
            'mahasiswa_id',    // Foreign key di tabel pivot (mengarah ke tabel mahasiswa)
            'jadwal_id',       // Primary key tabel jadwal
            'mahasiswa_id'     // Primary key tabel mahasiswa
        )->withPivot('tanggal', 'status', 'keterangan'); // Tambahkan kolom tambahan dari tabel pivot jika diperlukan
    }

}