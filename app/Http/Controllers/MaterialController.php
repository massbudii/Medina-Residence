<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialKawasan;
use App\Models\Kawasan;
use App\Models\TypeUnit;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with('materialKawasan.typeUnit');

        // FILTER TYPE
        if ($request->type_unit_id) {
            $query->whereHas('materialKawasan', function ($q) use ($request) {
                $q->where('type_unit_id', $request->type_unit_id);
            });
        }

        // FILTER KAWASAN
        if ($request->kawasan_id) {
            $query->whereHas('materialKawasan', function ($q) use ($request) {
                $q->where('kawasan_id', $request->kawasan_id);
            });
        }

        // AMBIL & GROUP (biar 1 material tampil 1x)
        $materials = $query->get();

        $kawasans = Kawasan::all();
        $types = TypeUnit::all();

        return view('admin.material.index', compact('materials', 'kawasans', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_material' => 'required',
            'satuan' => 'required',
            'kawasan_id' => 'required',
            'type_unit_id' => 'required|array',
        ], [
            'nama_material.required' => 'Nama material wajib diisi',
            'satuan.required' => 'Satuan wajib diisi',
            'kawasan_id.required' => 'Kawasan wajib dipilih',
            'type_unit_id.required' => 'Type unit wajib dipilih',
        ]);

        // CEGAH DUPLIKAT MATERIAL
        $material = Material::firstOrCreate(
            ['nama_material' => $request->nama_material],
            ['satuan' => $request->satuan]
        );

        foreach ($request->type_unit_id as $type) {
            // CEK DUPLIKAT PIVOT
            MaterialKawasan::firstOrCreate([
                'material_id' => $material->id,
                'kawasan_id' => $request->kawasan_id,
                'type_unit_id' => $type,
            ]);
        }

        return back()->with('success', 'Material berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_material' => 'required',
            'satuan' => 'required',
            'kawasan_id' => 'required',
            'type_unit_id' => 'required|array',
        ], [
            'nama_material.required' => 'Nama material wajib diisi',
            'satuan.required' => 'Satuan wajib diisi',
            'kawasan_id.required' => 'Kawasan wajib dipilih',
            'type_unit_id.required' => 'Type unit wajib dipilih',
        ]);

        $material = Material::findOrFail($id);

        $material->update([
            'nama_material' => $request->nama_material,
            'satuan' => $request->satuan,
        ]);

        // hapus pivot lama
        $material->materialKawasan()->delete();

        // insert ulang
        foreach ($request->type_unit_id as $type) {
            MaterialKawasan::create([
                'material_id' => $material->id,
                'kawasan_id' => $request->kawasan_id,
                'type_unit_id' => $type,
            ]);
        }

        return back()->with('success', 'Material berhasil diupdate');
    }


    public function nonaktif($id)
    {
        $material = Material::findOrFail($id);

        $material->update([
            'status' => 'nonaktif'
        ]);

        return back()->with('success', 'Material dinonaktifkan');
    }
    public function aktif($id)
    {
        $material = Material::findOrFail($id);

        $material->update([
            'status' => 'aktif'
        ]);

        return back()->with('success', 'Material diaktifkan');
    }
}
