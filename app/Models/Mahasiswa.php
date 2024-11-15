<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa'; // Nama tabel di database
    protected $primaryKey = 'mahasiswa_id'; // Primary key yang digunakan
    public $incrementing = true;
    protected $keyType = 'int';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'email',
        'password',
        'program_studi_id',
        'nim',
    ];

    // Relasi ke Program Studi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}