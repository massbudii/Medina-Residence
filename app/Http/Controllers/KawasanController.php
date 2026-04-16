<?php

namespace App\Http\Controllers;

use App\Models\Kawasan;
use App\Models\TypeUnit;
use Illuminate\Http\Request;

class KawasanController extends Controller
{
    public function index()
    {
        $data = Kawasan::with('typeUnits')->get();
        $types = TypeUnit::all();

        return view('admin.kawasan.index', compact('data', 'types'));
    }

    public function store(Request $request)
    {
        $kawasan = Kawasan::create([
            'nama_kawasan' => $request->nama_kawasan,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        // simpan relasi
        $kawasan->typeUnits()->attach($request->type_unit_id);

        return back()->with('success', 'Kawasan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kawasan = Kawasan::findOrFail($id);

        $kawasan->update([
            'nama_kawasan' => $request->nama_kawasan,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        // update relasi
        $kawasan->typeUnits()->sync($request->type_unit_id);

        return back()->with('success', 'Kawasan berhasil diupdate');
    }

    public function destroy($id)
    {
        Kawasan::findOrFail($id)->delete();

        return back()->with('success', 'Kawasan berhasil dihapus');
    }
}
