<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return view('admin.supplier.index', compact('supplier'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|unique:suppliers,nama_supplier',
            'alamat_supplier' => 'required',
            'no_hp' => 'required'
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nama_supplier.unique' => 'Nama supplier sudah ada',
            'alamat_supplier.required' => 'Alamat wajib diisi',
            'no_hp.required' => 'No HP wajib diisi',
        ]);

        Supplier::create($validated);

        return back()->with('success', 'Supplier berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'nama_supplier' => 'required|unique:suppliers,nama_supplier,' . $id,
            'alamat_supplier' => 'required',
            'no_hp' => 'required'
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nama_supplier.unique' => 'Nama supplier sudah ada',
            'alamat_supplier.required' => 'Alamat wajib diisi',
            'no_hp.required' => 'No HP wajib diisi',
        ]);

        $supplier->update($request->all());

        return back()->with('success', 'Supplier berhasil diupdate');
    }

    public function nonaktif($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'status' => 'nonaktif'
        ]);

        return back()->with('success', 'Supplier berhasil dinonaktifkan');
    }

    public function aktif($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'status' => 'aktif'
        ]);

        return back()->with('success', 'Supplier berhasil diaktifkan');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return back()->with('success', 'Supplier berhasil dihapus');
    }
}
