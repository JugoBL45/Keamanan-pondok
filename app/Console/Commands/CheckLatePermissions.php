<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permission;
use App\Models\Pelanggaran;
use App\Models\MasterPelanggaran;
use Carbon\Carbon;

class CheckLatePermissions extends Command
{
    protected $signature = 'permissions:check-late';
    protected $description = 'Check for late permissions and create violations if needed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $permissions = Permission::where('status', 'Belum Kembali')->get();
        $masterPelanggaran = MasterPelanggaran::where('nama', 'Terlambat kembali dari izin')->first();

        if (!$masterPelanggaran) {
            $this->error('Master Pelanggaran for late return not found.');
            return;
        }

        foreach ($permissions as $permission) {
            if (Carbon::now()->gt($permission->end_time)) {
                $permission->update(['status' => 'Telat']);
                Pelanggaran::create([
                    'id_santri' => $permission->id_santri,
                    'id_mp' => $masterPelanggaran->id,
                    'tanggal' => now(),
           
                ]);
            }
        }

        $this->info('Checked late permissions and created violations if needed.');
    }
}
