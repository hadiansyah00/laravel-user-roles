<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $table = 'program_studi'; // Nama tabel di database

    protected $primaryKey = 'program_studi_id'; // Kolom primary key

    public $incrementing = true; // Set true jika primary key auto increment
    protected $keyType = 'int'; // Tipe data primary key

    protected $fillable = [
        'name',

    ];
}
