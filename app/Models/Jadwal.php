<?php

namespace App\Models;

use App\Models\User;
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

    public function mataKuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id', 'matakuliah_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}