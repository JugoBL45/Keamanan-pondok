<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengurus;


class PengurusSeeder extends Seeder
{
    public function run()
    {
        Pengurus::create([
            'nama' => 'Muhamad Hafizh ',
            'jabatan' => 'Humas',
            'alamat' => 'Jl. Pepaya, Madiun',
            'email' => 'jugoblackride45@gmail.com',
            'telepon' => '085816024645',
        ]);

        Pengurus::create([
            'nama' => 'Jane Smith',
            'jabatan' => 'Sekretaris',
            'alamat' => 'Jl. Kebon Jeruk No.2',
            'email' => 'janesmith@example.com',
            'telepon' => '081298765432',
        ]);
    }
}