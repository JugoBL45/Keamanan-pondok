<?php

namespace App\Http\Controllers;

use App\Models\MasterLevel;
use Illuminate\Http\Request;

class MasterLevelController extends Controller
{
    public function index()
    {
        $masterLevels = MasterLevel::all();
        return view('master_level.index', compact('masterLevels'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'level' => 'required|integer|unique:master_levels',
            'denda' => 'nullable|string',
            'hukuman' => 'nullable|string',
        ]);

        MasterLevel::create($validatedData);

        return redirect()->route('master_level.index')->with('message', 'Data master level tersimpan ');
    }

    public function edit($id)
    {
        $masterLevel = MasterLevel::findOrFail($id);
        return response()->json($masterLevel);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'level' => 'required|integer|unique:master_levels,level,' . $id,
            'denda' => 'nullable|string',
            'hukuman' => 'nullable|string',
        ]);

        $masterLevel = MasterLevel::findOrFail($id);
        $masterLevel->update($validatedData);

        return redirect()->route('master_level.index')->with('message', 'Data master level terupdate ');
    }

    public function destroy($id)
    {
        MasterLevel::destroy($id);
        return redirect()->route('master_level.index')->with('message', 'Data master level terhapus ');

    }
}
