<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialMasuk;
use App\Models\MaterialTerpakai;
use App\Models\Kawasan;
use App\Models\Supplier;
use App\Models\TypeUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kawasan_id = $request->kawasan_id;

        // ===== CARD =====
        $totalType = TypeUnit::count();
        $totalKawasan = Kawasan::count();
        $totalSupplier = Supplier::count();

        $stokTotal = MaterialMasuk::sum('jumlah') - MaterialTerpakai::sum('jumlah');

        // ===== TABLE TYPE (LIMIT 10) =====
        $type = TypeUnit::limit(10)->get();

        // ===== MATERIAL QUERY (FILTER KAWASAN) =====
        $materials = Material::with([
            'materialMasuk' => function ($q) use ($kawasan_id) {
                if ($kawasan_id) {
                    $q->where('kawasan_id', $kawasan_id);
                }
            },
            'materialTerpakai' => function ($q) use ($kawasan_id) {
                if ($kawasan_id) {
                    $q->where('kawasan_id', $kawasan_id);
                }
            }
        ])->get();

        $dataMaterial = $materials->map(function ($m) {
            $masuk = $m->materialMasuk->sum('jumlah');
            $keluar = $m->materialTerpakai->sum('jumlah');
            $stok = $masuk - $keluar;

            return (object)[
                'nama_material' => $m->nama_material,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'stok' => $stok,
                'satuan' => $m->satuan,
            ];
        })->take(10);

        // ===== CHART (FIX BIAR SELARAS) =====
        $chartData = DB::table('material_masuk')
            ->selectRaw('DATE(tanggal_masuk) as tanggal, SUM(jumlah) as masuk')
            ->groupBy('tanggal');

        $chartKeluar = DB::table('material_terpakai')
            ->selectRaw('DATE(tanggal_pakai) as tanggal, SUM(jumlah) as keluar')
            ->groupBy('tanggal');

        if ($kawasan_id) {
            $chartData->where('kawasan_id', $kawasan_id);
            $chartKeluar->where('kawasan_id', $kawasan_id);
        }

        $masuk = $chartData->get()->keyBy('tanggal');
        $keluar = $chartKeluar->get()->keyBy('tanggal');

        $labels = $masuk->keys()->merge($keluar->keys())->unique()->sort()->values();

        $chartMasuk = $labels->map(fn($tgl) => $masuk[$tgl]->masuk ?? 0);
        $chartKeluar = $labels->map(fn($tgl) => $keluar[$tgl]->keluar ?? 0);

        $kawasans = Kawasan::all();

        return view('dashboard', compact(
            'totalType',
            'totalKawasan',
            'totalSupplier',
            'stokTotal',
            'type',
            'dataMaterial',
            'chartMasuk',
            'chartKeluar',
            'labels',
            'kawasans'
        ));
    }
}
