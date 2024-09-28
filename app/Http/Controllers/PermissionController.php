<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Santri;
use App\Models\MasterPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ActivityLog;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('santri')->get();
        $santris = Santri::all();
        return view('permissions.index', compact('permissions', 'santris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'reason' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $permission = Permission::create($request->all());

        // Update status based on current time compared to end_time
        $now = Carbon::now();
        $endDateTime = Carbon::parse($permission->end_time);
        $isLate = $now->gt($endDateTime); // Check if current time is greater than end time

        $status = $isLate ? 'Telat' : 'Belum Kembali';
        $permission->update(['status' => $status]);

        // If late, add a late return violation
        if ($isLate) {
            $this->addLateReturnViolation($permission->id_santri);
        }

        // Log activity
        $logMessage = "Membuat izin ID: {$permission->id} untuk Santri: {$permission->santri->nama}, Alasan: {$permission->reason}";
        ActivityLog::log($logMessage);

        return response()->json(['success' => 'Permission created successfully.']);
    }


    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'reason' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $permission->update($request->all());

        // Update status based on current time compared to end_time
        $now = Carbon::now();
        $endDateTime = Carbon::parse($permission->end_time);
        $isLate = $now->gt($endDateTime); // Check if current time is greater than end time

        $status = $isLate ? 'Telat' : 'Belum Kembali';
        $permission->update(['status' => $status]);

        // If late, add a late return violation
        if ($isLate) {
            $this->addLateReturnViolation($permission->id_santri);
        }

        // Log activity
        $logMessage = "Memperbarui izin ID: {$permission->id} untuk Santri: {$permission->santri->nama}, Alasan: {$permission->reason}";
        ActivityLog::log($logMessage);

        return response()->json(['success' => 'Permission updated successfully.']);
    }


    public function destroy(Permission $permission)
    {
        // Log activity before deleting
        $logMessage = "Menghapus izin ID: {$permission->id} untuk Santri: {$permission->santri->nama}, Alasan: {$permission->reason}";
        ActivityLog::log($logMessage);

        $permission->delete();
        return redirect()->route('perizinan.index')->with('success', 'Permission deleted successfully.');
    
    }
    public function getDashboardData()
{
    $jumlahPerizinan = Permission::count();

    return response()->json([
        'jumlahPerizinan' => $jumlahPerizinan,
    ]);
}


    public function markReturned(Request $request)
    {
        $permission = Permission::findOrFail($request->id);
        $now = Carbon::now();
        $endDateTime = Carbon::parse($permission->end_time);
        $isLate = $now->gt($endDateTime); // Check if current time is greater than end time

        $status = $isLate ? 'Telat' : 'Tepat Waktu';
        $permission->update(['status' => $status]);

        // If late, add to violation
        if ($isLate) {
            $this->addLateReturnViolation($permission->id_santri);
        }

        // Log activity
        $logMessage = "Memperbarui status izin ID: {$permission->id} untuk Santri: {$permission->santri->nama} menjadi {$status}";
        ActivityLog::log($logMessage);

        return response()->json(['success' => 'Permission status updated successfully.']);
    }


    private function addLateReturnViolation($santriId)
    {
        $lateReturnViolation = MasterPelanggaran::where('nama', 'Terlambat kembali dari izin')->first();

        if (!$lateReturnViolation) {
            return response()->json(['error' => 'Master Pelanggaran for late return not found.'], 404);
        }

        Pelanggaran::create([
            'id_santri' => $santriId,
            'id_mp' => $lateReturnViolation->id_mp,
            'tanggal' => Carbon::now(),
            'nama_pelanggaran' => $lateReturnViolation->nama, // Add the name of the violation
        ]);

        // Log activity
        $logMessage = "Membuat pelanggaran Terlambat Kembali dari Izin untuk Santri ID: {$santriId}";
        ActivityLog::log($logMessage);
    }

    

   
}


