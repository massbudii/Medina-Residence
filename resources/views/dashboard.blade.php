@extends('app')
@section('title', 'Dashboard')

@section('content')
    <style>
        .card:hover {
            transform: translateY(-3px);
            transition: 0.2s;
        }
    </style>


    <div class="col ">

        <!-- ================= CARD ================= -->
        <div class="row mt-3">

            <!-- TYPE UNIT -->
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-primary-subtle">

                        <div class="d-flex align-items-center">
                            <span
                                class="avatar-md rounded-circle bg-primary d-flex justify-content-center align-items-center me-3">
                                <i class="mdi mdi-home-variant text-white fs-22"></i>
                            </span>

                            <div>
                                <p class="mb-1 fw-semibold text-dark">Jumlah Type Unit</p>
                                <h3 class="mb-0 text-primary">{{ $totalType }}</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- KAWASAN -->
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-success-subtle">

                        <div class="d-flex align-items-center">
                            <span
                                class="avatar-md rounded-circle bg-success d-flex justify-content-center align-items-center me-3">
                                <i class="mdi mdi-map-marker-multiple text-white fs-22"></i>
                            </span>

                            <div>
                                <p class="mb-1 fw-semibold text-dark">Jumlah Kawasan</p>
                                <h3 class="mb-0 text-success">{{ $totalKawasan }}</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- SUPPLIER -->
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-warning-subtle">

                        <div class="d-flex align-items-center">
                            <span
                                class="avatar-md rounded-circle bg-warning d-flex justify-content-center align-items-center me-3">
                                <i class="mdi mdi-truck-delivery text-white fs-22"></i>
                            </span>

                            <div>
                                <p class="mb-1 fw-semibold text-dark">Jumlah Supplier</p>
                                <h3 class="mb-0 text-warning">{{ $totalSupplier }}</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- STOK -->
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-danger-subtle">

                        <div class="d-flex align-items-center">
                            <span
                                class="avatar-md rounded-circle bg-danger d-flex justify-content-center align-items-center me-3">
                                <i class="mdi mdi-warehouse text-white fs-22"></i>
                            </span>

                            <div>
                                <p class="mb-1 fw-semibold text-dark">Total Stok</p>
                                <h3 class="mb-0 text-danger">{{ $stokTotal }}</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <!-- ================= TABLE TYPE ================= -->
        <div class="card mt-3">
            <div class="card-body">

                <h4>Data Type Unit</h4>

                <table class="table table-bordered mb-0 text-start">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Type</th>
                            <th>Luas Bangunan</th>
                            <th>Luas Tanah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($type as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_type }}</td>
                                <td>{{ $item->luas_bangunan }}</td>
                                <td>{{ $item->luas_tanah }}</td>
                                <td>Rp {{ number_format($item->harga_rumah, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>


        <!-- ================= TABLE MATERIAL ================= -->
        <div class="card mt-3">
            <div class="card-body">

                <h4>Data Material</h4>

                <!-- FILTER -->
                <form method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="kawasan_id" class="form-control">
                                <option value="">-- Semua Kawasan --</option>
                                @foreach ($kawasans as $k)
                                    <option value="{{ $k->id }}"
                                        {{ request('kawasan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kawasan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- TABLE -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Material</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dataMaterial as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_material }}</td>
                                <td>{{ $item->masuk }}</td>
                                <td>{{ $item->keluar }}</td>
                                <td>{{ $item->satuan }}</td>
                                <td>
                                    <b class="{{ $item->stok < 10 ? 'text-danger' : '' }}">
                                        {{ $item->stok }}
                                    </b>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>



    </div>

@endsection

@section('script')

    

@endsection
