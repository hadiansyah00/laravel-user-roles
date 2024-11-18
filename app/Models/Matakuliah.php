<?php

namespace App\Models;

use App\Models\Jadwal;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matakuliah extends Model
{
    use HasFactory;

    protected $table = 'matakuliah';

    // Primary Key
    protected $primaryKey = 'matakuliah_id';

    protected $fillable = [
        'program_studi_id',
        'name',
        'code',
        'semester',
    ];

    // Relasi ke Program Studi
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'matakuliah_id', 'matakuliah_id');
    }

}