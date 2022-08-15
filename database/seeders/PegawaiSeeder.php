<?php

namespace Database\Seeders;

use App\Models\AkunPegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AkunPegawai::create([
            'id_admin' => '1',
            'name' => 'Fihan',
            'email' => 'a@gmail.com',
            'password' => bcrypt('fihan123'),
            'id_jabatan' => '1',
            'role' => 'Pegawai',
            'jumlah_kerja' => '367',
            'tanggal_masuk' => '2022-07-31',
            'status' => 'Aktif',
        ]);
    }
}
