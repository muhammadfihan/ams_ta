<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = "penggajian";
    protected $fillable = [
        'id_admin',
        'email',
        'tanggal',
        'no_pegawai',
        'id_jabatan',
        'id_golongan',
        'jam_kerja',
        'status',
        'id_tunjangan',
        'id_bonus',
        'id_potongan',
        'total_gaji'
    ];
}
