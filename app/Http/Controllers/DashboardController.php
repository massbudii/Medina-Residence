<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialMasuk;
use App\Models\MaterialTerpakai;
use App\Models\Kawasan;
use App\Models\Laporan;
use App\Models\Supplier;
use App\Models\TypeUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kawasan_id = $request->kawasan_id;

        // ===== SUMMARY CARD =====
        $totalUser = User::count();
        $totalType = TypeUnit::count();
        $totalKawasan = Kawasan::count();
        $totalSupplier = Supplier::count();
        $totalMaterial = Material::count();

        $totalMasuk = MaterialMasuk::when($kawasan_id, fn ($q) => $q->where('kawasan_id', $kawasan_id))->sum('jumlah');
        $totalKeluar = MaterialTerpakai::when($kawasan_id, fn ($q) => $q->where('kawasan_id', $kawasan_id))->sum('jumlah');
        $stokTotal = $totalMasuk - $totalKeluar;

        $laporanDiajukan = Laporan::where('status', 'diajukan')->count();
        $laporanDisetujui = Laporan::where('status', 'disetujui')->count();
        $laporanDitolak = Laporan::where('status', 'ditolak')->count();

        // ===== KELOLA DATA TABLES =====
        $type = TypeUnit::withCount('kawasans')
            ->latest()
            ->limit(8)
            ->get();

        $kawasanSummary = Kawasan::withCount('typeUnits')
            ->withSum('materialMasuk as total_material_masuk', 'jumlah')
            ->withSum('materialKeluar as total_material_keluar', 'jumlah')
            ->latest()
            ->limit(8)
            ->get();

        $supplierSummary = Supplier::withCount('materialMasuk')
            ->withSum('materialMasuk as total_pasokan', 'jumlah')
            ->latest()
            ->limit(8)
            ->get();

        $latestUsers = User::latest()
            ->limit(6)
            ->get();

        // ===== MATERIAL STOCK TABLE =====
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
        })->sortBy('stok')->values();

        $stockWarning = $dataMaterial->where('stok', '<', 10)->count();
        $dataMaterialTable = $dataMaterial->take(10);

        // ===== CHART MATERIAL MASUK VS KELUAR =====
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
        $chartLabels = $labels->map(fn($tgl) => date('d M', strtotime($tgl)));

        // ===== CHART STOK MATERIAL =====
        $stockChartData = $dataMaterial
            ->sortByDesc('stok')
            ->take(8)
            ->values();

        $stockChartLabels = $stockChartData->pluck('nama_material');
        $stockChartValues = $stockChartData->pluck('stok');

        // ===== RECENT OPERATIONAL DATA =====
        $latestMasuk = MaterialMasuk::with(['material', 'supplier', 'kawasan'])
            ->when($kawasan_id, fn ($q) => $q->where('kawasan_id', $kawasan_id))
            ->latest('tanggal_masuk')
            ->limit(5)
            ->get();

        $latestKeluar = MaterialTerpakai::with(['material', 'kawasan'])
            ->when($kawasan_id, fn ($q) => $q->where('kawasan_id', $kawasan_id))
            ->latest('tanggal_pakai')
            ->limit(5)
            ->get();

        $kawasans = Kawasan::all();

        return view('dashboard', compact(
            'totalUser',
            'totalType',
            'totalKawasan',
            'totalSupplier',
            'totalMaterial',
            'totalMasuk',
            'totalKeluar',
            'stokTotal',
            'laporanDiajukan',
            'laporanDisetujui',
            'laporanDitolak',
            'type',
            'kawasanSummary',
            'supplierSummary',
            'latestUsers',
            'dataMaterialTable',
            'stockWarning',
            'chartMasuk',
            'chartKeluar',
            'chartLabels',
            'stockChartLabels',
            'stockChartValues',
            'latestMasuk',
            'latestKeluar',
            'kawasans'
        ));
    }
}
