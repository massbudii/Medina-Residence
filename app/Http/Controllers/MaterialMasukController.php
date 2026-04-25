<?php

namespace App\Http\Controllers;

use App\Models\MaterialMasuk;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\Kawasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MaterialMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialMasuk::with(['material', 'supplier', 'kawasan']);

        $isFilter = $request->filled('kawasan_id')
            || $request->filled('dari')
            || $request->filled('sampai')
            || $request->filled('bulan')
            || $request->filled('tahun');

        // filter kawasan
        if ($request->kawasan_id) {
            $query->where('kawasan_id', $request->kawasan_id);
        }

        // filter tanggal (INI KUNCI)
        if ($request->dari && !$request->sampai) {
            $query->whereDate('tanggal_masuk', $request->dari);
        }

        if ($request->dari && $request->sampai) {
            $query->whereBetween('tanggal_masuk', [$request->dari, $request->sampai]);
        }

        // filter bulan
        if ($request->bulan) {
            $query->whereMonth('tanggal_masuk', $request->bulan);
        }

        // filter tahun
        if ($request->tahun) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        // TAMBAH STOK TANPA RESET QUERY
        $query->select('material_masuk.*')
            ->addSelect([
                'stok' => DB::table('material_masuk as mm')
                    ->selectRaw('SUM(mm.jumlah)')
                    ->whereColumn('mm.material_id', 'material_masuk.material_id')
                    ->whereColumn('mm.kawasan_id', 'material_masuk.kawasan_id')
            ]);

        $data = $isFilter ? $query->latest()->get() : collect();

        return view('admin.material_masuk.index', [
            'data' => $data,
            'isFilter' => $isFilter,
            'materials' => Material::where('status', 'aktif')->get(),
            'suppliers' => Supplier::all(),
            'kawasans' => Kawasan::all(),
        ]);
    }

    //  STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'kawasan_id' => 'required|exists:kawasans,id',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ], [
            'material_id.required' => 'Material wajib dipilih',
            'material_id.exists' => 'Material tidak valid',

            'supplier_id.required' => 'Supplier wajib dipilih',
            'supplier_id.exists' => 'Supplier tidak valid',

            'kawasan_id.required' => 'Kawasan wajib dipilih',
            'kawasan_id.exists' => 'Kawasan tidak valid',

            'tanggal_masuk.required' => 'Tanggal wajib diisi',
            'tanggal_masuk.date' => 'Format tanggal tidak valid',

            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.integer' => 'Jumlah harus angka',
            'jumlah.min' => 'Jumlah minimal 1',
        ]);

        MaterialMasuk::create($validated);

        return back()
            ->with('success', 'Material masuk berhasil ditambahkan');
    }

    //  UPDATE
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'kawasan_id' => 'required|exists:kawasans,id',
            'tanggal_masuk' => 'required|date',
            'jumlah' => 'required|integer|min:1',
        ], [
            'material_id.required' => 'Material wajib dipilih',
            'supplier_id.required' => 'Supplier wajib dipilih',
            'kawasan_id.required' => 'Kawasan wajib dipilih',
            'tanggal_masuk.required' => 'Tanggal wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
        ]);

        $data = MaterialMasuk::findOrFail($id);
        $data->update($validated);

        return back()
            ->with('success', 'Material masuk berhasil diupdate');
    }

    //  DELETE
    public function destroy($id)
    {
        $data = MaterialMasuk::findOrFail($id);
        $data->delete();

        return back()
            ->with('success', 'Material masuk berhasil dihapus');
    }
}
