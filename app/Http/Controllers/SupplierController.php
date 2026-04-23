<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        $validated = $request->validate([
            'nama_supplier' => ['required', Rule::unique('suppliers', 'nama_supplier')->ignore($id)],
            'alamat_supplier' => 'required',
            'no_hp' => 'required'
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nama_supplier.unique' => 'Nama supplier sudah ada',
            'alamat_supplier.required' => 'Alamat wajib diisi',
            'no_hp.required' => 'No HP wajib diisi',
        ]);

        $supplier->update($validated);

        return back()->with('success', 'Supplier berhasil diudpate');

    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return back()->with('succes', 'Supplier berhasil dihapus');
    }

    public function aktif($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'status'=> 'aktif'
        ]);

        return back()->with('success', 'Supplier berhasil diaktifkan');
    }
    public function nonaktif($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'status'=> 'nonaktif'
        ]);

        return back()->with('success', 'Supplier berhasil di noanaktifkan');
    }

}
