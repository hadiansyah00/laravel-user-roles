<?php

namespace App\Models;

use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\ProgramStudi;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa'; // Nama tabel di database
    protected $primaryKey = 'mahasiswa_id'; // Primary key yang digunakan
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true; // Pastikan timestamps aktif jika tabel menggunakan kolom 'created_at' dan 'updated_at'

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'program_studi_id',
        'nim',
    ];

    /**
     * Kolom yang disembunyikan saat data dikembalikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kolom yang di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Hash password sebelum menyimpan ke database.
     */

    /**
     * Relasi ke Program Studi.
     */
    // public function programStudi()
    // {
    //     return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    // }
    // public function absensi()
    // {
    //     return $this->hasMany(Absensi::class, 'mahasiswa_id');
    // }
     // Relasi ke model ProgramStudi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'program_studi_id');
    }

    // Relasi ke model Absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'mahasiswa_id', 'mahasiswa_id');
    }

    // Relasi ke model Jadwal melalui tabel pivot Absensi
    public function jadwal()
    {
        return $this->belongsToMany(
            Jadwal::class,
            'absensi',         // Tabel pivot
            'mahasiswa_id',    // Foreign key di tabel pivot (mengarah ke tabel ini)
            'jadwal_id',       // Foreign key di tabel pivot (mengarah ke tabel jadwal)
            'mahasiswa_id',    // Primary key tabel mahasiswa
            'jadwal_id'        // Primary key tabel jadwal
        )->withPivot('tanggal', 'status', 'keterangan'); // Tambahkan kolom tambahan dari tabel pivot jika diperlukan
    }
}