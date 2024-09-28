<?php
// database/seeders/PermissionsTableSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Santri;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $santris = Santri::all();

        foreach ($santris as $santri) {
            Permission::create([
                'santri_id' => $santri->id,
                'reason' => 'Keperluan mendesak',
                'start_time' => now()->subDays(rand(1, 10)),
                'end_time' => now()->addDays(rand(1, 5)),
                'status' => 'approved',
            ]);

            Permission::create([
                'santri_id' => $santri->id,
                'reason' => 'Kunjungan keluarga',
                'start_time' => now()->subDays(rand(1, 10)),
                'end_time' => now()->addDays(rand(1, 5)),
                'status' => 'pending',
            ]);
        }
    }
}
