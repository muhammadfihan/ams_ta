<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = "laporan";
    protected $fillable = [
        'id_admin',
        'id_jabatan',
        'email',
        'tanggal_laporan',
        'no_pegawai',
        'nama_lengkap',
        'deskripsi',
        'lampiran',
        'status_laporan'
    ];
}
