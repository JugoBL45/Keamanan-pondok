<?php

namespace Database\Seeders;

use App\Models\Santri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nis' => '144',
                'nama'  => 'Toni',
                'kelas' => 1,
                'alamat' => 'Madiun',
                'walisantri' => 'joko',
                'no_wali'   => '09876543',
            ],
            [
                'nis'=> '145',
                'nama'  => 'Stark',
                'kelas' => 1,
                'alamat' => 'Madiun',
                'walisantri' => 'joko',
                'no_wali'   => '09876543',
            ],
            [
                'nis'=> '146',
                'nama'  => 'Ayunda',
                'kelas' => 1,
                'alamat' => 'Madiun',
                'walisantri' => 'joko',
                'no_wali'   => '09876543',
            ],
            [
                'nis'=> '147',
                'nama'  => 'Betty',
                'kelas' => 1,
                'alamat' => 'Madiun',
                'walisantri' => 'joko',
                'no_wali'   => '09876543',
            ]
        ];

        foreach ($data as $key => $value) {
            Santri::create($value);
        }
    }
}
