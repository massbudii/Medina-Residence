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
        $validated = $request->validate([
            'nama_kawasan' => 'required',
            'alamat' => 'required',
            'status' => 'required',
            'type_unit_id' => 'required|array'
        ], [
            'nama_kawasan.required' => 'Nama kawasan wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'status.required' => 'Status wajib dipilih',
            'type_unit_id.required' => 'Type unit wajib dipilih',
        ]);

        // simpan kawasan
        $kawasan = Kawasan::create([
            'nama_kawasan' => $validated['nama_kawasan'],
            'alamat' => $validated['alamat'],
            'status' => $validated['status'],
        ]);

        // simpan relasi
        $kawasan->typeUnits()->attach($validated['type_unit_id']);

        return back()->with('success', 'Kawasan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kawasan = Kawasan::findOrFail($id);

        $validated = $request->validate([
            'nama_kawasan' => 'required',
            'alamat' => 'required',
            'status' => 'required',
            'type_unit_id' => 'required|array'
        ], [
            'nama_kawasan.required' => 'Nama kawasan wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'status.required' => 'Status wajib dipilih',
            'type_unit_id.required' => 'Type unit wajib dipilih',
        ]);

        // update data utama
        $kawasan->update([
            'nama_kawasan' => $validated['nama_kawasan'],
            'alamat' => $validated['alamat'],
            'status' => $validated['status'],
        ]);

        // update relasi
        $kawasan->typeUnits()->sync($validated['type_unit_id']);

        return back()->with('success', 'Kawasan berhasil diupdate');
    }

    public function destroy($id)
    {
        $kawasan = Kawasan::findOrFail($id);

        // hapus relasi dulu
        $kawasan->typeUnits()->detach();

        $kawasan->delete();

        return back()->with('success', 'Kawasan berhasil dihapus');
    }

    public function aktif($id)
    {
        $kawasan = Kawasan::findOrFail($id);

        if ($kawasan->status !== 'aktif') {
            $kawasan->update([
                'status' => 'aktif'
            ]);
        }

        return back()->with('success', 'Kawasan berhasil diaktifkan');
    }

    public function selesai($id)
    {
        $kawasan = Kawasan::findOrFail($id);

        if ($kawasan->status !== 'selesai') {
            $kawasan->update([
                'status' => 'selesai'
            ]);
        }

        return back()->with('success', 'Kawasan telah selesai pengerjaan');
    }
}
