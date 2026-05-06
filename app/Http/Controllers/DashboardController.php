<?php

namespace App\Http\Controllers;


use App\Models\Material;
use App\Models\MaterialMasuk;
use App\Models\MaterialTerpakai;
use App\Models\Kawasan;
use App\Models\Supplier;
use App\Models\TypeUnit;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== CARD =====
        $totalType = TypeUnit::count();
        $totalKawasan = Kawasan::count();
        $totalSupplier = Supplier::count();

        // stok total = masuk - keluar
        $stokTotal = MaterialMasuk::sum('jumlah') - MaterialTerpakai::sum('jumlah');

        // ===== TABLE KAWASAN + TYPE =====
        $type = TypeUnit::all();

        // ===== TABLE MATERIAL =====
        $materials = Material::with('materialMasuk', 'materialTerpakai')->get();

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
        });

        // ===== CHART =====
        $chartMasuk = MaterialMasuk::selectRaw('DATE(tanggal_masuk) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->pluck('total');

        $chartKeluar = MaterialTerpakai::selectRaw('DATE(tanggal_pakai) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->pluck('total');

        $labels = MaterialMasuk::selectRaw('DATE(tanggal_masuk) as tanggal')
            ->groupBy('tanggal')
            ->pluck('tanggal');

        return view('dashboard', compact(
            'totalType',
            'totalKawasan',
            'totalSupplier',
            'stokTotal',
            'type',
            'dataMaterial',
            'chartMasuk',
            'chartKeluar',
            'labels'
        ));
    }
}
