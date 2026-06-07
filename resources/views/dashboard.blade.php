@extends('app')
@section('title', 'Dashboard')

@section('content')
    <style>
        .dashboard-page {
            padding-top: 1rem;
        }

        .dashboard-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .dashboard-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--bs-heading-color);
            margin-bottom: .25rem;
        }

        .dashboard-subtitle {
            color: var(--bs-secondary-color);
            margin-bottom: 0;
        }

        .metric-card {
            border: 1px solid var(--bs-border-color);
            box-shadow: 0 .125rem .5rem rgba(0, 0, 0, .035);
            height: 100%;
        }

        .metric-card .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .9rem;
        }

        .metric-label {
            color: var(--bs-secondary-color);
            font-weight: 600;
            margin-bottom: .35rem;
        }

        .metric-value {
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0;
        }

        .metric-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .section-card {
            border: 1px solid var(--bs-border-color);
            box-shadow: 0 .125rem .5rem rgba(0, 0, 0, .035);
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
        }

        .section-note {
            color: var(--bs-secondary-color);
            font-size: .8125rem;
        }

        .dashboard-table {
            margin-bottom: 0;
        }

        .dashboard-table thead th {
            background: var(--bs-light);
            color: var(--bs-heading-color);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: 0;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .dashboard-table td,
        .dashboard-table th {
            vertical-align: middle;
        }

        .text-truncate-table {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chart-box {
            min-height: 318px;
        }

        @media (max-width: 767.98px) {
            .dashboard-header {
                display: block;
            }

            .dashboard-filter {
                margin-top: 1rem;
            }
        }
    </style>

    <div class="dashboard-page">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Dashboard Material Medina Residence</h1>
                <p class="dashboard-subtitle">Ringkasan master data, stok, dan pergerakan material proyek.</p>
            </div>

            <form method="GET" class="dashboard-filter">
                <div class="input-group">
                    <select name="kawasan_id" class="form-select">
                        <option value="">Semua Kawasan</option>
                        @foreach ($kawasans as $kawasan)
                            <option value="{{ $kawasan->id }}" {{ request('kawasan_id') == $kawasan->id ? 'selected' : '' }}>
                                {{ $kawasan->nama_kawasan }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">
                        <i class="mdi mdi-filter-variant me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="row g-3">
            <div class="col-sm-6 col-xl-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <div>
                            <p class="metric-label">Total Material</p>
                            <h2 class="metric-value">{{ number_format($totalMaterial, 0, ',', '.') }}</h2>
                        </div>
                        <span class="metric-icon bg-primary-subtle text-primary">
                            <i class="mdi mdi-package-variant-closed fs-22"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <div>
                            <p class="metric-label">Stok Tersedia</p>
                            <h2 class="metric-value">{{ number_format($stokTotal, 0, ',', '.') }}</h2>
                        </div>
                        <span class="metric-icon bg-success-subtle text-success">
                            <i class="mdi mdi-warehouse fs-22"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <div>
                            <p class="metric-label">Material Masuk</p>
                            <h2 class="metric-value">{{ number_format($totalMasuk, 0, ',', '.') }}</h2>
                        </div>
                        <span class="metric-icon bg-info-subtle text-info">
                            <i class="mdi mdi-login fs-22"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <div>
                            <p class="metric-label">Material Keluar</p>
                            <h2 class="metric-value">{{ number_format($totalKeluar, 0, ',', '.') }}</h2>
                        </div>
                        <span class="metric-icon bg-danger-subtle text-danger">
                            <i class="mdi mdi-logout fs-22"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-sm-6 col-xl-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <div>
                            <p class="metric-label">Type Unit</p>
                            <h2 class="metric-value">{{ number_format($totalType, 0, ',', '.') }}</h2>
                        </div>
                        <span class="metric-icon bg-secondary-subtle text-secondary">
                            <i class="mdi mdi-home-city-outline fs-22"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <div>
                            <p class="metric-label">Kawasan</p>
                            <h2 class="metric-value">{{ number_format($totalKawasan, 0, ',', '.') }}</h2>
                        </div>
                        <span class="metric-icon bg-warning-subtle text-warning">
                            <i class="mdi mdi-map-marker-radius-outline fs-22"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <div>
                            <p class="metric-label">Supplier</p>
                            <h2 class="metric-value">{{ number_format($totalSupplier, 0, ',', '.') }}</h2>
                        </div>
                        <span class="metric-icon bg-primary-subtle text-primary">
                            <i class="mdi mdi-truck-delivery-outline fs-22"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card metric-card">
                    <div class="card-body">
                        <div>
                            <p class="metric-label">Total User</p>
                            <h2 class="metric-value">{{ number_format($totalUser, 0, ',', '.') }}</h2>
                        </div>
                        <span class="metric-icon bg-danger-subtle text-danger">
                            <i class="mdi mdi-account-group-outline fs-22"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-8">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="section-title">Perbandingan Material Masuk dan Keluar</h3>
                                <span class="section-note">Akumulasi jumlah material berdasarkan tanggal transaksi.</span>
                            </div>
                        </div>
                        <div id="materialMovementChart" class="chart-box"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="mb-3">
                            <h3 class="section-title">Stok Barang</h3>
                            <span class="section-note">Material dengan stok tertinggi dari filter aktif.</span>
                        </div>
                        <div id="stockChart" class="chart-box"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-7">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Stok Material</h3>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-danger-subtle text-danger">{{ $stockWarning }} stok menipis</span>
                                <a href="{{ route('material.index') }}" class="btn btn-sm btn-outline-primary">Kelola Data</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th class="text-end">Masuk</th>
                                        <th class="text-end">Keluar</th>
                                        <th class="text-end">Stok</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dataMaterialTable as $item)
                                        <tr>
                                            <td class="fw-semibold">{{ $item->nama_material }}</td>
                                            <td class="text-end">{{ number_format($item->masuk, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($item->keluar, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                <span class="badge {{ $item->stok < 10 ? 'bg-danger' : 'bg-success' }}">
                                                    {{ number_format($item->stok, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>{{ $item->satuan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada data material</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Data Kawasan</h3>
                            <a href="{{ route('kawasan.index') }}" class="btn btn-sm btn-outline-primary">Kelola Data</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Kawasan</th>
                                        <th>Status</th>
                                        <th class="text-end">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kawasanSummary as $kawasan)
                                        @php
                                            $stokKawasan = ($kawasan->total_material_masuk ?? 0) - ($kawasan->total_material_keluar ?? 0);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $kawasan->nama_kawasan }}</div>
                                                <div class="text-muted small">{{ $kawasan->type_units_count }} type unit</div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $kawasan->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($kawasan->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end fw-semibold">{{ number_format($stokKawasan, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">Belum ada data kawasan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-6">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Data Type Unit</h3>
                            <a href="{{ route('type.index') }}" class="btn btn-sm btn-outline-primary">Kelola Data</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th class="text-end">Bangunan</th>
                                        <th class="text-end">Tanah</th>
                                        <th class="text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($type as $item)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $item->nama_type }}</div>
                                                <div class="text-muted small">{{ $item->kawasans_count }} kawasan</div>
                                            </td>
                                            <td class="text-end">{{ number_format($item->luas_bangunan, 0, ',', '.') }} m2</td>
                                            <td class="text-end">{{ number_format($item->luas_tanah, 0, ',', '.') }} m2</td>
                                            <td class="text-end">Rp {{ number_format($item->harga_rumah ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data type unit</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Data Supplier</h3>
                            <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-outline-primary">Kelola Data</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>Kontak</th>
                                        <th class="text-end">Transaksi</th>
                                        <th class="text-end">Pasokan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($supplierSummary as $supplier)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $supplier->nama_supplier }}</div>
                                                <div class="text-muted small text-truncate-table">{{ $supplier->alamat_supplier }}</div>
                                            </td>
                                            <td>{{ $supplier->no_hp }}</td>
                                            <td class="text-end">{{ number_format($supplier->material_masuk_count, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($supplier->total_pasokan ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data supplier</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-xl-7">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Data User</h3>
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-outline-primary">Kelola Data</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($latestUsers as $user)
                                        <tr>
                                            <td class="fw-semibold">{{ $user->nama }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ ucfirst($user->role) }}</td>
                                            <td>
                                                <span class="badge {{ $user->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data user</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Status Laporan</h3>
                            <a href="{{ route('laporan.data') }}" class="btn btn-sm btn-outline-primary">Kelola Data</a>
                        </div>

                        <div class="row g-2">
                            <div class="col-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small mb-1">Diajukan</div>
                                    <div class="fs-4 fw-bold text-warning">{{ number_format($laporanDiajukan, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small mb-1">Disetujui</div>
                                    <div class="fs-4 fw-bold text-success">{{ number_format($laporanDisetujui, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small mb-1">Ditolak</div>
                                    <div class="fs-4 fw-bold text-danger">{{ number_format($laporanDitolak, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-light border mb-0 mt-3">
                            <div class="fw-semibold">Monitoring pengajuan laporan</div>
                            <div class="text-muted small">Pantau laporan proyek berdasarkan status persetujuan terbaru.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1 mb-3">
            <div class="col-xl-6">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Material Masuk Terbaru</h3>
                            <a href="{{ route('material_masuk.index') }}" class="btn btn-sm btn-outline-primary">Kelola Data</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Material</th>
                                        <th>Kawasan</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($latestMasuk as $item)
                                        <tr>
                                            <td>{{ date('d M Y', strtotime($item->tanggal_masuk)) }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $item->material->nama_material ?? '-' }}</div>
                                                <div class="text-muted small">{{ $item->supplier->nama_supplier ?? '-' }}</div>
                                            </td>
                                            <td>{{ $item->kawasan->nama_kawasan ?? '-' }}</td>
                                            <td class="text-end">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada material masuk</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card section-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Material Terpakai Terbaru</h3>
                            <a href="{{ route('material_terpakai.index') }}" class="btn btn-sm btn-outline-primary">Kelola Data</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Material</th>
                                        <th>Kawasan</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($latestKeluar as $item)
                                        <tr>
                                            <td>{{ date('d M Y', strtotime($item->tanggal_pakai)) }}</td>
                                            <td class="fw-semibold">{{ $item->material->nama_material ?? '-' }}</td>
                                            <td>{{ $item->kawasan->nama_kawasan ?? '-' }}</td>
                                            <td class="text-end">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada material terpakai</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="badge bg-warning-subtle text-warning">Laporan diajukan: {{ $laporanDiajukan }}</span>
                            <span class="badge bg-success-subtle text-success">Disetujui: {{ $laporanDisetujui }}</span>
                            <span class="badge bg-danger-subtle text-danger">Ditolak: {{ $laporanDitolak }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const movementLabels = @json($chartLabels);
            const movementMasuk = @json($chartMasuk);
            const movementKeluar = @json($chartKeluar);
            const stockLabels = @json($stockChartLabels);
            const stockValues = @json($stockChartValues);

            const emptyText = '<div class="text-center text-muted py-5">Belum ada data untuk ditampilkan</div>';

            if (movementLabels.length) {
                new ApexCharts(document.querySelector('#materialMovementChart'), {
                    chart: {
                        type: 'area',
                        height: 318,
                        toolbar: { show: false }
                    },
                    series: [
                        { name: 'Material Masuk', data: movementMasuk },
                        { name: 'Material Keluar', data: movementKeluar }
                    ],
                    colors: ['#287F71', '#E7366B'],
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3 },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: .25,
                            opacityTo: .02
                        }
                    },
                    xaxis: {
                        categories: movementLabels,
                        labels: { rotate: -35 }
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return Math.round(value).toLocaleString('id-ID');
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right'
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return Number(value).toLocaleString('id-ID');
                            }
                        }
                    }
                }).render();
            } else {
                document.querySelector('#materialMovementChart').innerHTML = emptyText;
            }

            if (stockLabels.length) {
                new ApexCharts(document.querySelector('#stockChart'), {
                    chart: {
                        type: 'bar',
                        height: 318,
                        toolbar: { show: false }
                    },
                    series: [{ name: 'Stok', data: stockValues }],
                    colors: ['#108dff'],
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 4,
                            distributed: false
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(value) {
                            return Number(value).toLocaleString('id-ID');
                        }
                    },
                    xaxis: {
                        categories: stockLabels
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return Number(value).toLocaleString('id-ID');
                            }
                        }
                    }
                }).render();
            } else {
                document.querySelector('#stockChart').innerHTML = emptyText;
            }
        });
    </script>
@endsection
