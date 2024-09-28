<?php
namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Permission;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Santri;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $santris = Santri::all(); // Retrieve all santri data
        $oneYearAgo = Carbon::now()->subYear();

        // Retrieve pelanggaran data
        $pelanggaranData = Pelanggaran::where('tanggal', '>=', $oneYearAgo)
            ->selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        // Retrieve permission data
        $perizinanData = Permission::where('start_time', '>=', $oneYearAgo)
            ->selectRaw('DATE_FORMAT(start_time, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        $data = [
            'labels' => [],
            'pelanggaran' => [],
            'perizinan' => [],
        ];

        // Merge and sort unique months
        $months = collect([...$pelanggaranData, ...$perizinanData])
            ->pluck('month')
            ->unique()
            ->sort()
            ->values();

        foreach ($months as $month) {
            $data['labels'][] = $month;
            $data['pelanggaran'][] = $pelanggaranData->firstWhere('month', $month)->count ?? 0;
            $data['perizinan'][] = $perizinanData->firstWhere('month', $month)->count ?? 0;
        }

        // Pass data to the view
        return view('dashboard.index', compact('santris', 'data'));
    }
    
    public function getBarChartData()
    {
        $oneYearAgo = Carbon::now()->subYear();

        $pelanggaranData = Pelanggaran::where('tanggal', '>=', $oneYearAgo)
            ->selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        $perizinanData = Permission::where('start_time', '>=', $oneYearAgo)
            ->selectRaw('DATE_FORMAT(start_time, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        $data = [
            'labels' => [],
            'pelanggaran' => [],
            'perizinan' => [],
        ];

        $months = collect([...$pelanggaranData, ...$perizinanData])
            ->pluck('month')
            ->unique()
            ->sort()
            ->values();

        foreach ($months as $month) {
            $data['labels'][] = $month;
            $data['pelanggaran'][] = $pelanggaranData->firstWhere('month', $month)->count ?? 0;
            $data['perizinan'][] = $perizinanData->firstWhere('month', $month)->count ?? 0;
        }

        return response()->json($data);
    }

    
    
    public function topSantri()
{
    $kelas = [
        ['id' => 1, 'nama_kelas' => 'Idadiyah'],
        ['id' => 2, 'nama_kelas' => '2 Ibtida\''],
        ['id' => 3, 'nama_kelas' => '3 Ibtida\''],
        ['id' => 4, 'nama_kelas' => '4 Ibtida\''],
        ['id' => 5, 'nama_kelas' => '5 Ibtida\''],
        ['id' => 6, 'nama_kelas' => '6 Ibtida\''],
        ['id' => 7, 'nama_kelas' => '1 Tsanawiyah'],
        ['id' => 8, 'nama_kelas' => '2 Tsanawiyah'],
        ['id' => 9, 'nama_kelas' => '3 Tsanawiyah'],
        ['id' => 10, 'nama_kelas' => 'Ulya']
    ];

    // Membuat peta dari ID kelas ke nama kelas
    $kelasMap = collect($kelas)->pluck('nama_kelas', 'id');

    $topSantri = Pelanggaran::select('id_santri', Santri::raw('COUNT(*) as total'))
        ->groupBy('id_santri')
        ->orderBy('total', 'desc')
        ->with(['santri' => function ($query) {
            $query->with('kelas');
        }])
        ->take(8)
        ->get()
        ->map(function ($pelanggaran) use ($kelasMap) {
            return [
                'nama' => $pelanggaran->santri->nama,
                'foto' => $pelanggaran->santri->foto,
                'kelas' => $kelasMap[$pelanggaran->santri->kelas_id] ?? 'Unknown',
                'total' => $pelanggaran->total
            ];
        });

    return response()->json($topSantri);
}


}
