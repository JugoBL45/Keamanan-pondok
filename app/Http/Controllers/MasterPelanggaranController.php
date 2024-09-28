<?php

namespace App\Http\Controllers;

use App\Models\MasterPelanggaran;
use App\Models\MasterLevel;
use Illuminate\Http\Request;

class MasterPelanggaranController extends Controller
{
    public function index()
    {
        $masterPelanggarans = MasterPelanggaran::all();
        $masterLevels = MasterLevel::all();
        return view('master_pelanggaran.index', compact('masterPelanggarans', 'masterLevels'));
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'larangan' => 'required|string',
            'level' => 'required|integer',
            'max' => 'required|integer',
        ]);

        // Fetch corresponding MasterLevel data
        $masterLevel = MasterLevel::where('level', $validatedData['level'])->firstOrFail();

        // Assign denda and hukuman from MasterLevel to validatedData
        $validatedData['denda'] = $masterLevel->denda;
        $validatedData['hukuman'] = $masterLevel->hukuman;

        // Create new MasterPelanggaran
        MasterPelanggaran::create($validatedData);

        return redirect()->route('master_pelanggaran.index')->with('success', 'Master Pelanggaran berhasil disimpan.');


    }

    public function edit($id)
    {
        $masterPelanggaran = MasterPelanggaran::findOrFail($id);
        return response()->json($masterPelanggaran);
    }
    
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'larangan' => 'required|string',
            'level' => 'required|integer',
            'max' => 'required|integer',
        ]);
    
        // Fetch corresponding MasterLevel data
        $masterLevel = MasterLevel::where('level', $validatedData['level'])->firstOrFail();
    
        // Assign denda and hukuman from MasterLevel to validatedData
        $validatedData['denda'] = $masterLevel->denda;
        $validatedData['hukuman'] = $masterLevel->hukuman;
    
        // Update the existing MasterPelanggaran
        $masterPelanggaran = MasterPelanggaran::findOrFail($id);
        $masterPelanggaran->update($validatedData);
    
        return redirect()->route('master_pelanggaran.index')->with('success', 'Master Pelanggaran berhasil disimpan.');
    }
    
    public function destroy($id)
    {
        MasterPelanggaran::destroy($id);
        return redirect()->route('master_pelanggaran.index')->with('success', 'Master Pelanggaran berhasil disimpan.');

    }
}
