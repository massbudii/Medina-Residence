<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Laporan;
use App\Models\Kawasan;
use App\Models\MaterialMasuk;
use App\Models\MaterialTerpakai;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // ================= DATA PENGAJUAN =================
        if ($user->role == 'admin') {
            $laporans = Laporan::with(['kawasan', 'pembuat'])
                ->latest()
                ->get();
        } else {
            $laporans = Laporan::with(['kawasan', 'penyetuju'])
                ->where('dibuat_oleh', $user->id)
                ->latest()
                ->get();
        }

        // ================= FILTER MATERIAL =================
        $kawasan = $request->kawasan_id;
        $dari = $request->dari;
        $sampai = $request->sampai;

        $isFilter = $request->filled('kawasan_id') &&
            $request->filled('dari') &&
            $request->filled('sampai');

        $data = collect();

        if ($isFilter) {

            $masuk = MaterialMasuk::with(['material', 'kawasan'])
                ->where('kawasan_id', $kawasan)
                ->whereBetween('tanggal_masuk', [$dari, $sampai])
                ->get()
                ->map(function ($item) {
                    $item->tipe = 'masuk';
                    $item->tanggal = $item->tanggal_masuk;
                    return $item;
                });

            $keluar = MaterialTerpakai::with(['material', 'kawasan'])
                ->where('kawasan_id', $kawasan)
                ->whereBetween('tanggal_pakai', [$dari, $sampai])
                ->get()
                ->map(function ($item) {
                    $item->tipe = 'keluar';
                    $item->tanggal = $item->tanggal_pakai;
                    return $item;
                });

            $data = $masuk->merge($keluar)
                ->sortBy('tanggal')
                ->values();

            // stok berjalan
            $stok = 0;
            $data = $data->map(function ($item) use (&$stok) {
                $stok += ($item->tipe == 'masuk') ? $item->jumlah : -$item->jumlah;
                $item->stok = $stok;
                return $item;
            });
        }

        return view('admin.laporan.index', [
            'laporans' => $laporans,
            'data' => $data,
            'kawasans' => Kawasan::all(),
            'isFilter' => $isFilter
        ]);
    }

    // ================= AJUKAN =================
    public function store(Request $request)
    {
        $request->validate([
            'kawasan_id' => 'required',
            'dari' => 'required|date',
            'sampai' => 'required|date|after_or_equal:dari',
        ]);

        Laporan::create([
            'kawasan_id' => $request->kawasan_id,
            'dari' => $request->dari,
            'sampai' => $request->sampai,
            'dibuat_oleh' => Auth::id(),
            'status' => 'diajukan'
        ]);

        return back()->with('success', 'Laporan diajukan');
    }

    // ================= APPROVE =================
    public function approve($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->status != 'diajukan') {
            return back()->with('error', 'Sudah diambil admin lain');
        }

        $laporan->update([
            'status' => 'disetujui',
            'disetujui_oleh' => Auth::id()
        ]);

        return back()->with('success', 'Disetujui');
    }

    public function data(Request $request)
    {
        $kawasan = $request->kawasan_id;
        $dari = $request->dari;
        $sampai = $request->sampai;

        $isFilter = $request->filled('kawasan_id') &&
            $request->filled('dari') &&
            $request->filled('sampai');

        $data = collect();

        if ($isFilter) {

            $masuk = MaterialMasuk::with(['material', 'kawasan'])
                ->where('kawasan_id', $kawasan)
                ->whereBetween('tanggal_masuk', [$dari, $sampai])
                ->get()
                ->map(function ($item) {
                    $item->tipe = 'masuk';
                    $item->tanggal = $item->tanggal_masuk;
                    return $item;
                });

            $keluar = MaterialTerpakai::with(['material', 'kawasan'])
                ->where('kawasan_id', $kawasan)
                ->whereBetween('tanggal_pakai', [$dari, $sampai])
                ->get()
                ->map(function ($item) {
                    $item->tipe = 'keluar';
                    $item->tanggal = $item->tanggal_pakai;
                    return $item;
                });

            $data = $masuk->merge($keluar)->sortBy('tanggal')->values();

            $stok = 0;
            $data = $data->map(function ($item) use (&$stok) {
                $stok += ($item->tipe == 'masuk') ? $item->jumlah : -$item->jumlah;
                $item->stok = $stok;
                return $item;
            });
        }

        return view('admin.laporan.data', [
            'data' => $data,
            'kawasans' => Kawasan::all(),
            'isFilter' => $isFilter
        ]);
    }

    public function print($id)
    {
        $laporan = Laporan::with(['kawasan', 'pembuat', 'penyetuju'])
            ->findOrFail($id);

        if ($laporan->status != 'disetujui') {
            return back()->with('error', 'Belum disetujui');
        }

        // ================= AMBIL DATA MATERIAL =================
        $masuk = MaterialMasuk::with(['material'])
            ->where('kawasan_id', $laporan->kawasan_id)
            ->whereBetween('tanggal_masuk', [$laporan->dari, $laporan->sampai])
            ->get()
            ->map(function ($item) {
                $item->tipe = 'masuk';
                $item->tanggal = $item->tanggal_masuk;
                return $item;
            });

        $keluar = MaterialTerpakai::with(['material'])
            ->where('kawasan_id', $laporan->kawasan_id)
            ->whereBetween('tanggal_pakai', [$laporan->dari, $laporan->sampai])
            ->get()
            ->map(function ($item) {
                $item->tipe = 'keluar';
                $item->tanggal = $item->tanggal_pakai;
                return $item;
            });

        $data = $masuk->merge($keluar)
            ->sortBy('tanggal')
            ->values();

        // ================= STOK BERJALAN =================
        $stok = 0;
        $data = $data->map(function ($item) use (&$stok) {
            $stok += ($item->tipe == 'masuk') ? $item->jumlah : -$item->jumlah;
            $item->stok = $stok;
            return $item;
        });

        return view('admin.laporan.print', [
            'data' => $data, // ✅ INI YANG KURANG
            'kawasan' => $laporan->kawasan,
            'dari' => $laporan->dari,
            'sampai' => $laporan->sampai,
            'dibuat' => $laporan->pembuat,
            'disetujui' => $laporan->penyetuju,
        ]);
    }
}
