<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $kelas = [
            ['nama_kelas' => 'Idadiyah'],
            ['nama_kelas' => '2 Ibtida\''],
            ['nama_kelas' => '3 Ibtida\''],
            ['nama_kelas' => '4 Ibtida\''],
            ['nama_kelas' => '5 Ibtida\''],
            ['nama_kelas' => '6 Ibtida\''],
            ['nama_kelas' => '1 Tsanawiyah'],
            ['nama_kelas' => '2 Tsanawiyah'],
            ['nama_kelas' => '3 Tsanawiyah'],
            ['nama_kelas' => 'Ulya']
        ];

        DB::table('kelas')->insert($kelas);
    }
}
