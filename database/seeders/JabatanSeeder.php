<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan =  [
            [
                'id' => '1',
                'id_admin' => '1',
                'jabatan' => 'Manager',
                'gaji' => '8000000'
            ],
            [
                'id' => '2',
                'id_admin' => '1',
                'jabatan' => 'Admin HRD',
                'gaji' => '5000000'
            ],
            [
                'id' => '3',
                'id_admin' => '1',
                'jabatan' => 'HRD',
                'gaji' => '5000000'
            ],
            [
                'id' => '4',
                'id_admin' => '1',
                'jabatan' => 'Staff HRD',
                'gaji' => '4500000'
            ],
            [
                'id' => '5',
                'id_admin' => '1',
                'jabatan' => 'Programmer',
                'gaji' => '10000000'
            ],

          ];

          Jabatan::insert($jabatan);
    }
}
