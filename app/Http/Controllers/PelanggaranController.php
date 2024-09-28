<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Santri;
use App\Models\MasterPelanggaran;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\ActivityLog;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date');
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $query = Pelanggaran::with(['santri', 'masterPelanggaran']);

        if ($date) {
            $query->whereDate('tanggal', $date);
        } else {
            $query->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year);
        }

        $pelanggarans = $query->get();
        $santris = Santri::all();
        $masterPelanggarans = MasterPelanggaran::all();

        return view('pelanggaran.harian.index', compact('pelanggarans', 'santris', 'masterPelanggarans'));
    }

    public function index2(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $pelanggarans = Pelanggaran::with(['santri', 'masterPelanggaran'])
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $santris = Santri::all();
        $masterPelanggarans = MasterPelanggaran::all();

        return view('pelanggaran.bulanan.index', compact('pelanggarans', 'santris', 'masterPelanggarans'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'id_mp' => 'required|exists:master_pelanggarans,id_mp',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pelanggaran_photos', 'public');
        }

        $masterPelanggaran = MasterPelanggaran::find($data['id_mp']);

        // Periksa apakah max > 0 sebelum melakukan pengecekan
        if ($masterPelanggaran->max > 0) {
            $currentPelanggaranCount = Pelanggaran::where('id_santri', $data['id_santri'])
                ->where('id_mp', $data['id_mp'])
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->count();

            // Cek apakah sudah ada entri otomatis sebelumnya
            $existingAutoPelanggaran = Pelanggaran::where('id_santri', $data['id_santri'])
                ->where('id_mp', $data['id_mp'])
                ->where('nama_pelanggaran', 'like', $masterPelanggaran->nama . ' (%)')
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->first();

            if ($currentPelanggaranCount >= $masterPelanggaran->max) {
                if ($existingAutoPelanggaran) {
                    // Update existing auto entry
                    $existingAutoPelanggaran->nama_pelanggaran = $masterPelanggaran->nama . ' (' . ($currentPelanggaranCount + 1) . ')';
                    $existingAutoPelanggaran->save();
                } else {
                    // Buat entri pelanggaran baru dengan nama_pelanggaran yang diperbarui
                    $newPelanggaran = new Pelanggaran();
                    $newPelanggaran->id_santri = $data['id_santri'];
                    $newPelanggaran->id_mp = $data['id_mp'];
                    // Atur tanggal sesuai bulan dari input
                    $newPelanggaran->tanggal = Carbon::create($request->input('year'), $request->input('month'), 1);
                    $newPelanggaran->foto = isset($data['foto']) ? $data['foto'] : null;
                    $newPelanggaran->nama_pelanggaran = $masterPelanggaran->nama . ' (' . ($currentPelanggaranCount + 1) . ')';
                    $newPelanggaran->save();
                }
            }
        }

        // Buat entri pelanggaran baru tanpa memperbarui nama_pelanggaran
        $data['nama_pelanggaran'] = $masterPelanggaran->nama; // Set default nama_pelanggaran
        $pelanggaran = Pelanggaran::create($data);

        // Log aktivitas
        $logMessage = "Membuat pelanggaran ID: {$pelanggaran->id} untuk Santri: {$pelanggaran->santri->nama}, Pelanggaran: {$pelanggaran->nama_pelanggaran}";
        ActivityLog::log($logMessage);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pelanggaran.tambah.index')->with('success', 'Pelanggaran berhasil disimpan.');
    }

    public function tambahIndex()
    {
        $santris = Santri::all();
        $masterPelanggarans = MasterPelanggaran::all();
        $larangans = MasterPelanggaran::distinct()->pluck('larangan');

        return view('pelanggaran.tambah.index', compact('santris', 'masterPelanggarans', 'larangans'));
    }


    public function laporan(Request $request)
    {
        $type = $request->input('type', 'daily');
        $date = $request->input('date', Carbon::now()->toDateString());
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        if ($type == 'daily') {
            $pelanggarans = Pelanggaran::with(['santri', 'masterPelanggaran'])
                ->whereDate('tanggal', $date)
                ->get();
        } else {
            $pelanggarans = Pelanggaran::with(['santri', 'masterPelanggaran'])
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->get();
        }

        $santris = Santri::all();
        $masterPelanggarans = MasterPelanggaran::all();

        return view('laporan.index', compact('pelanggarans', 'santris', 'masterPelanggarans', 'type', 'date', 'month', 'year'));
    }

    public function edit($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        return response()->json($pelanggaran);
    }
    public function getDashboardData()
    {
        $jumlahPelanggaran = Pelanggaran::count();

        return response()->json([
            'jumlahPelanggaran' => $jumlahPelanggaran,
        ]);
    }

    public function update(Request $request, $id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($pelanggaran->foto) {
                Storage::disk('public')->delete($pelanggaran->foto);
            }

            $data['foto'] = $request->file('foto')->store('pelanggaran_photos', 'public');
        }

        $pelanggaran->update($data);

        // Log aktivitas
        $logMessage = "Memperbarui pelanggaran ID: {$pelanggaran->id} untuk Santri: {$pelanggaran->santri->nama}, Pelanggaran: {$pelanggaran->nama_pelanggaran}";
        ActivityLog::log($logMessage);

        return response()->json(['message' => 'Pelanggaran updated successfully']);
    }
    public function toggleStatus($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        // Toggle status
        $pelanggaran->status = $pelanggaran->status == 'Terlaksana' ? 'Belum Terlaksana' : 'Terlaksana';
        $pelanggaran->save();

        $logMessage = "Merubah Status Pelanggaran menjadi: {$pelanggaran->status} untuk Santri: {$pelanggaran->santri->nama}, Pelanggaran: {$pelanggaran->nama_pelanggaran}";
        ActivityLog::log($logMessage);


        return response()->json(['status' => $pelanggaran->status]);
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        if ($pelanggaran->foto) {
            Storage::disk('public')->delete($pelanggaran->foto);
        }

        // Log aktivitas
        $logMessage = "Menghapus pelanggaran ID: {$pelanggaran->id} untuk Santri: {$pelanggaran->santri->nama}, Pelanggaran: {$pelanggaran->nama_pelanggaran}";
        ActivityLog::log($logMessage);

        $pelanggaran->delete();

        return response()->json(['message' => 'Pelanggaran deleted successfully']);
    }

    public function getBarChartData()
    {
        $currentYear = Carbon::now()->year;

        $pelanggaranData = Pelanggaran::whereYear('tanggal', $currentYear)
            ->selectRaw('MONTH(tanggal) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        $perizinanData = Permission::whereYear('start_time', $currentYear)
            ->selectRaw('MONTH(start_time) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        $data = [
            'labels' => [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ],
            'pelanggaran' => array_fill(0, 12, 0),
            'perizinan' => array_fill(0, 12, 0),
        ];

        foreach ($pelanggaranData as $pelanggaran) {
            $data['pelanggaran'][$pelanggaran->month - 1] = $pelanggaran->count;
        }

        foreach ($perizinanData as $perizinan) {
            $data['perizinan'][$perizinan->month - 1] = $perizinan->count;
        }

        return response()->json($data);
    }
    public function topTroublesomeSantri()
    {
        $topSantri = Santri::withCount('pelanggarans')
            ->orderBy('pelanggarans_count', 'desc')
            ->first();

        if (!$topSantri) {
            return response()->json(['error' => 'No troublesome santri found.'], 404);
        }

        $jumlahPelanggaran = $topSantri->pelanggarans_count;
        $jumlahPerizinan = Permission::where('id_santri', $topSantri->id_santri)->count();

        return response()->json([
            'nama' => $topSantri->nama,
            'foto' => $topSantri->foto,
            'jumlahPelanggaran' => $jumlahPelanggaran,
            'jumlahPerizinan' => $jumlahPerizinan,
            'totalPelanggaranPerizinan' => $jumlahPelanggaran + $jumlahPerizinan,
        ]);
    }
}
