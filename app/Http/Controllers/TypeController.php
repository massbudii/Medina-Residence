<?php

namespace App\Http\Controllers;

use App\Models\TypeUnit;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.type.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_type' => 'required',
            'luas_bangunan' => 'required|integer',
            'luas_tanah' => 'required|integer',
            'harga_rumah' => 'required|decimal:0,2'

        ], [
            'nama_type.required' => 'Kolom waib diisi',
            'luas_bangunan.required' => 'Kolom waib diisi',
            'luas_tanah.required' => 'Kolom waib diisi',
            'harga_rumah.required' => 'Kolom waib diisi',

        ]);

            TypeUnit::create($validated);
            return back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
