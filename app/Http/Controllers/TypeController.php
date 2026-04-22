<?php

namespace App\Http\Controllers;

use App\Models\TypeUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $type = TypeUnit::all();
        return view('admin.type.index', compact('type'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_type' => 'required|unique:type_units,nama_type',
            'luas_bangunan' => 'required|integer',
            'luas_tanah' => 'required|integer',
            'harga_rumah' => 'required|numeric'

        ], [
            'nama_type.required' => 'Kolom waib diisi',
            'nama_type.unique' => 'Nama type terserbut sudah ada',
            'luas_bangunan.required' => 'Kolom waib diisi',
            'luas_tanah.required' => 'Kolom waib diisi',
            'harga_rumah.required' => 'Kolom waib diisi',

        ]);

        TypeUnit::create($validated);
        return back()->with('success', 'Data berhasil ditambahkan');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = TypeUnit::findOrFail($id);

        $validated = $request->validate([
            'nama_type' => [
                'required',
                Rule::unique('type_units', 'nama_type')->ignore($id)
            ],
            'luas_bangunan' => 'required|integer',
            'luas_tanah' => 'required|integer',
            'harga_rumah' => 'required|numeric'
        ], [
            'nama_type.required' => 'Kolom wajib diisi',
            'nama_type.unique' => 'Nama type sudah ada ',
            'luas_bangunan.required' => 'Kolom wajib diisi',
            'luas_tanah.required' => 'Kolom wajib diisi',
            'harga_rumah.required' => 'Kolom wajib diisi',
        ]);

        $type->update($validated);

        return back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = TypeUnit::findOrFail($id);

        $type->delete();
        return back()->with('success', 'Data berhasil di hapus');
    }
}
