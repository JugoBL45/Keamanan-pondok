<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Pelanggaran;
use App\Models\Permission;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SantriController extends Controller
{
    public function index()
    {
        $santris = Santri::with('kelas')->get(); // Eager load the 'kelas' relationship
        $kelas = Kelas::all();
        return view('santri.index', compact('santris', 'kelas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nis' => 'required|unique:santris',
            'nama' => 'required',
            'kelas_id' => 'required',
            'alamat' => 'required',
            'walisantri' => 'required',
            'no_wali' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image
        ]);

        if ($request->hasFile('foto')) {
            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
            $validatedData['foto'] = $imageName;
        }

        Santri::create($validatedData);

        // Log activity
        $logMessage = "Membuat santri baru: {$request->nama}";
        ActivityLog::log($logMessage);

        return redirect()->route('santri.index')->with('success', 'Santri created successfully');
    }

    public function edit($id)
    {
        $santri = Santri::findOrFail($id);
        return response()->json($santri);
    }

    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        $validatedData = $request->validate([
            'nis' => 'required|unique:santris,nis,' . $santri->id_santri . ',id_santri',
            'nama' => 'required',
            'kelas_id' => 'required',
            'alamat' => 'required',
            'walisantri' => 'required',
            'no_wali' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image
        ]);

        if ($request->hasFile('foto')) {
            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images'), $imageName);
            $validatedData['foto'] = $imageName;
        }

        $santri->update($validatedData);

        // Log activity
        $logMessage = "Memperbarui data santri: {$santri->nama}";
        ActivityLog::log($logMessage);

        return redirect()->route('santri.index')->with('success', 'Santri updated successfully');
    }

    public function toggleStatus(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);
        $santri->status = $santri->status == 'Aktif' ? 'Tidak Aktif' : 'Aktif';
        $santri->save();

        // Log activity
        $logMessage = "Mengubah status santri: {$santri->nama} menjadi {$santri->status}";
        ActivityLog::log($logMessage);

        return response()->json([
            'status' => $santri->status,
        ]);
    }


    public function destroy($id)
    {
        $santri = Santri::findOrFail($id);

        // Log activity
        $logMessage = "Menghapus santri: {$santri->nama}";
        ActivityLog::log($logMessage);

        $santri->delete();
        return redirect()->route('santri.index')->with('success', 'Santri deleted successfully');
    }
    public function laporan($id)
    {
        $santri = Santri::with('pelanggaran.masterPelanggaran')->find($id);

        if (!$santri) {
            return redirect()->back()->with('error', 'Santri tidak ditemukan.');
        }

        $violations = $santri->pelanggaran;

        $totalDenda = $violations ? $violations->sum(function ($violation) {
            return $violation->masterPelanggaran->denda;
        }) : 0;

        // Ambil user yang sedang login
        $user = auth()->user();

        return view('santri.profil', compact('santri', 'violations', 'totalDenda', 'user'));
    }

    public function getDashboardData()
    {
        $jumlahSantri = Santri::count();

        return response()->json([
            'jumlahSantri' => $jumlahSantri,
        ]);
    }

    public function profil($id)
    {
        $santri = Santri::with('kelas')->findOrFail($id);
        return view('santri.profil', compact('santri'));
    }


    public function sendWhatsApp($id)
    {
        $santri = Santri::find($id);
    
        if (!$santri) {
            return response()->json(['success' => false, 'message' => 'Santri tidak ditemukan']);
        }
        
        $totalDenda = $santri->pelanggaran->sum('masterPelanggaran.denda');
        $formattedDenda = number_format($totalDenda, 0, ',', '.');
        $username = Auth::user()->name;
    
        // Membentuk pesan pelanggaran
        $violations = $santri->pelanggaran->filter(function ($pelanggaran) {
            return $pelanggaran->status !== 'Terlaksana';
        });
    
        $violationMessage = "";
        foreach ($violations as $index => $pelanggaran) {
            $denda = number_format($pelanggaran->masterPelanggaran->denda ?? 0, 0, ',', '.');
            $violationMessage .= ($index + 1) . ". " . $pelanggaran->nama_pelanggaran . " - " . $pelanggaran->tanggal . " - Rp" . $denda . "\n";
        }
    
        $message = "Kepada Bapak/Ibu {$santri->walisantri} yang terhormat,\n\n";
        $message .= "Dengan ini kami sampaikan bahwa santri {$santri->nama} telah tercatat melakukan beberapa pelanggaran yang memerlukan perhatian. Berikut adalah detail pelanggaran:\n\n";
        $message .= $violationMessage;
        $message .= "\nTotal denda yang terakumulasi akibat pelanggaran tersebut adalah sebesar Rp {$formattedDenda}. Kami mohon perhatian dan kerjasamanya dalam menangani masalah ini.\n\n";
        $message .= "Konsekuensi: Santri ini tidak dapat mengambil rapor atau mengikuti ujian tamrin dan ujian akhir apabila denda pelanggarannya tidak dilunaskan.\n\n";
        $message .= "Hormat kami,\n";
        $message .= "({$username})";
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $santri->no_wali,
                'message' => $message,
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: " . env('FONNTE_API_KEY'),
            ),
        ));
    
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return response()->json(['success' => false, 'message' => 'Error: ' . $error_msg]);
        }
        curl_close($curl);
    
        $responseData = json_decode($response, true);
    
        if ($responseData && isset($responseData['status']) && $responseData['status'] == 'success') {
            return response()->json(['success' => true, 'message' => 'Pesan WhatsApp berhasil dikirim']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim pesan WhatsApp']);
        }
    }
    
}    
