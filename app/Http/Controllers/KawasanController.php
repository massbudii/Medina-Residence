<?php

namespace App\Http\Controllers;

use App\Models\Kawasan;
use App\Models\TypeUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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
            'nama_kawasan' => 'required|unique:kawasans,nama_kawasan',
            'alamat' => 'required',
            'status' => 'required',
            'type_unit_id' => 'required|array|min:1',
            'type_unit_id.*' => 'exists:type_units,id',
        ], [
            'nama_kawasan.required' => 'Nama kawasan wajib diisi',
            'nama_kawasan.unique' => 'Nama kawasan tersebut telah ada',
            'alamat.required' => 'Alamat wajib diisi',
            'status.required' => 'Status wajib dipilih',
            'type_unit_id.required' => 'Type unit wajib dipilih',
            'type_unit_id.min' => 'Minimal pilih 1 type unit',
        ]);

        DB::beginTransaction();

        try {
            // simpan kawasan
            $kawasan = Kawasan::create([
                'nama_kawasan' => $validated['nama_kawasan'],
                'alamat' => $validated['alamat'],
                'status' => $validated['status'],
            ]);

            // simpan relasi
            $kawasan->typeUnits()->attach($validated['type_unit_id']);

            DB::commit();

            return redirect()->back()->with('success', 'Kawasan berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menambahkan data');
        }
    }

    public function update(Request $request, $id)
    {
        $kawasan = Kawasan::findOrFail($id);

        $validated = $request->validate([
            'nama_kawasan' => ['required', Rule::unique('kawasans', 'nama_kawasan')->ignore($id)],
            'alamat' => 'required',
            'type_unit_id' => 'required|array|min:1',
            'type_unit_id.*' => 'exists:type_units,id',
        ], [
            'nama_kawasan.required' => 'Nama kawasan wajib diisi',
            'nama_kawasan.unique' => 'Nama kawasan tersebut telah ada',
            'alamat.required' => 'Alamat wajib diisi',
            'type_unit_id.required' => 'Type unit wajib dipilih',
            'type_unit_id.min' => 'Minimal pilih 1 type unit',
        ]);

        DB::beginTransaction();

        try {
            // update data utama
            $kawasan->update([
                'nama_kawasan' => $validated['nama_kawasan'],
                'alamat' => $validated['alamat'],
            ]);

            // update relasi
            $kawasan->typeUnits()->sync($validated['type_unit_id']);

            DB::commit();

            return redirect()->back()->with('success', 'Kawasan berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal update data');
        }
    }

    public function destroy($id)
    {
        $kawasan = Kawasan::findOrFail($id);

        DB::beginTransaction();

        try {
            $kawasan->typeUnits()->detach();
            $kawasan->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Kawasan berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal hapus data');
        }
    }

    public function aktif($id)
    {
        $kawasan = Kawasan::findOrFail($id);

        if ($kawasan->status !== 'aktif') {
            $kawasan->update([
                'status' => 'aktif'
            ]);
        }

        return redirect()->back()->with('success', 'Kawasan berhasil diaktifkan');
    }

    public function selesai($id)
    {
        $kawasan = Kawasan::findOrFail($id);

        if ($kawasan->status !== 'selesai') {
            $kawasan->update([
                'status' => 'selesai'
            ]);
        }

        return redirect()->back()->with('success', 'Kawasan telah selesai pengerjaan');
    }
}
