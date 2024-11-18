<?php

namespace App\Models;

use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{

    use HasFactory;

    // Nama tabel
    protected $table = 'jadwal';

    // Primary key
    protected $primaryKey = 'jadwal_id';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'matakuliah_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'status_absensi',
    ];

    // Relasi ke model MataKuliah
    public function mataKuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'matakuliah_id');
    }
}
