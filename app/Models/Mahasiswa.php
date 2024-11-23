<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'mahasiswa_id');
    }
}