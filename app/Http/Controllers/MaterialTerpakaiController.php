<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Kawasan;
use App\Models\MaterialMasuk;
use App\Models\MaterialTerpakai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialTerpakaiController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialTerpakai::with(['material', 'kawasan']);

        $isFilter = $request->filled('kawasan_id') || $request->filled('dari');

        if ($request->kawasan_id) {
            $query->where('kawasan_id', $request->kawasan_id);
        }

        if ($request->dari) {
            $query->whereDate('tanggal_pakai', $request->dari);
        }

        // stok realtime
        $query->select('material_terpakai.*')
            ->addSelect([
                'stok' => DB::table('material_masuk as mm')
                    ->selectRaw('SUM(mm.jumlah) - COALESCE((
                        SELECT SUM(mt.jumlah) FROM material_terpakai mt
                        WHERE mt.material_id = mm.material_id
                        AND mt.kawasan_id = mm.kawasan_id
                    ),0)')
                    ->whereColumn('mm.material_id', 'material_terpakai.material_id')
                    ->whereColumn('mm.kawasan_id', 'material_terpakai.kawasan_id')
            ]);

        $data = $query->latest()->get();

        return view('admin.material_terpakai.index', [
            'data' => $data,
            'isFilter' => $isFilter,
            'materials' => Material::where('status', 'aktif')->get(),
            'kawasans' => Kawasan::where('status', 'aktif')->get(),
            'semuaKawasans' => Kawasan::all(),
        ]);
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'mandor', 403);

        $request->validate([
            'material_id' => 'required',
            'kawasan_id' => 'required',
            'tanggal_pakai' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
        ]);

        // CEK STATUS KAWASAN
        $kawasan = Kawasan::findOrFail($request->kawasan_id);
        if ($kawasan->status === 'selesai') {
            return back()->with('error', 'Kawasan dengan status selesai tidak dapat ditambahkan material terpakai');
        }

        // HITUNG STOK
        $masuk = MaterialMasuk::where('material_id', $request->material_id)
            ->where('kawasan_id', $request->kawasan_id)
            ->sum('jumlah');

        $terpakai = MaterialTerpakai::where('material_id', $request->material_id)
            ->where('kawasan_id', $request->kawasan_id)
            ->sum('jumlah');

        $stok = $masuk - $terpakai;

        // VALIDASI STOK
        if ($request->jumlah > $stok) {
            return back()->withErrors([
                'jumlah' => 'Stok tidak mencukupi!'
            ])->withInput();
        }

        MaterialTerpakai::create([
            'material_id' => $request->material_id,
            'kawasan_id' => $request->kawasan_id,
            'tanggal_pakai' => $request->tanggal_pakai,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('material_terpakai.index')
            ->with('success', 'Material terpakai berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        abort_if(Auth::user()->role !== 'mandor', 403);

        $data = MaterialTerpakai::findOrFail($id);

        $request->validate([
            'material_id' => 'required',
            'kawasan_id' => 'required',
            'tanggal_pakai' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
        ]);

        // CEK STATUS KAWASAN
        $kawasan = Kawasan::findOrFail($request->kawasan_id);
        if ($kawasan->status === 'selesai') {
            return back()->with('error', 'Kawasan dengan status selesai tidak dapat diupdate material terpakai');
        }

        // HITUNG ULANG STOK TANPA DATA INI
        $masuk = MaterialMasuk::where('material_id', $request->material_id)
            ->where('kawasan_id', $request->kawasan_id)
            ->sum('jumlah');

        $terpakai = MaterialTerpakai::where('material_id', $request->material_id)
            ->where('kawasan_id', $request->kawasan_id)
            ->where('id', '!=', $id)
            ->sum('jumlah');

        $stok = $masuk - $terpakai;

        if ($request->jumlah > $stok) {
            return back()->withErrors([
                'jumlah' => 'Stok tidak mencukupi!'
            ])->withInput();
        }

        $data->update([
            'material_id' => $request->material_id,
            'kawasan_id' => $request->kawasan_id,
            'tanggal_pakai' => $request->tanggal_pakai,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('material_terpakai.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        abort_if(Auth::user()->role !== 'mandor', 403);

        MaterialTerpakai::findOrFail($id)->delete();
        return redirect()->route('material_terpakai.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
