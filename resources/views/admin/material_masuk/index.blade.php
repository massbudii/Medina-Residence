@extends('app')
@section('title', 'Material Masuk')

@section('content')
    <div class="col">

        <div class="card mt-3">


            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Data Material Masuk</h2>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                    Tambah Material Masuk
                </button>
            </div>

            <div class="card-body">

                <!-- FILTER -->
                <form method="GET" action="{{ route('material_masuk.index') }}">
                    <div class="row mb-3">

                        <div class="col-md-4">
                            <select name="kawasan_id" class="form-control">
                                <option value="">-- Filter Kawasan --</option>
                                @foreach ($kawasans as $kawasan)
                                    <option value="{{ $kawasan->id }}"
                                        {{ request('kawasan_id') == $kawasan->id ? 'selected' : '' }}>
                                        {{ $kawasan->nama_kawasan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                        </div>

                        <div class="col-md-4">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('material_masuk.index') }}" class="btn btn-warning">Reset</a>
                        </div>

                    </div>
                </form>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered text-start" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kawasan</th>
                                <th>Material</th>
                                <th>Supplier</th>
                                <th>Jumlah</th>
                                <th>Stok</th>
                                <th style="width: 1%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @if (!$isFilter)
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Untuk menampilkan data silahkan filter terlebih dahulu
                                    </td>
                                </tr>
                            @else
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tanggal_masuk }}</td>
                                        <td>{{ $item->kawasan->nama_kawasan }}</td>
                                        <td>{{ $item->material->nama_material }}</td>
                                        <td>{{ $item->supplier->nama_supplier }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->stok }}</td>

                                        <td class="text-nowrap">

                                            <!-- EDIT -->
                                            <a href="#" class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id }}">
                                                <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                            </a>

                                            <!-- DELETE -->
                                            <a href="#" class="btn btn-icon btn-sm bg-danger-subtle"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal1{{ $item->id }}"
                                                title="Hapus">
                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                            </a>

                                        </td>
                                    </tr>

                                    <div class="modal fade" id="deleteModal1{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus <b>{{ $item->material_masuk }}</b> ?
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Batal</button>

                                                    <form action="{{ route('material_masuk.destroy', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn bg-danger btn-danger">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-dark">
                                            Data tidak ditemukan
                                        </td>
                                    </tr>
                                @endforelse

                            @endif

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- ================= TAMBAH MODAL ================= -->
    <div class="modal fade" id="standard-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('material_masuk.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="tambah">

                    <div class="modal-header">
                        <h5>Tambah Material Masuk</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-2">
                            <label>Kawasan</label>
                            <select name="kawasan_id" class="form-control">
                                <option value="">-- pilih --</option>
                                @foreach ($kawasans as $kawasan)
                                    <option value="{{ $kawasan->id }}"
                                        {{ old('kawasan_id') == $kawasan->id ? 'selected' : '' }}>
                                        {{ $kawasan->nama_kawasan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kawasan_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label>Material</label>
                            <select name="material_id" class="form-control">
                                <option value="">-- pilih --</option>
                                @foreach ($materials as $m)
                                    <option value="{{ $m->id }}"
                                        {{ old('material_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_material }}
                                    </option>
                                @endforeach
                            </select>
                            @error('material_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label>Supplier</label>
                            <select name="supplier_id" class="form-control">
                                <option value="">-- pilih --</option>
                                @foreach ($suppliers as $s)
                                    <option value="{{ $s->id }}"
                                        {{ old('supplier_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal_masuk" class="form-control"
                                value="{{ old('tanggal_masuk') }}">
                            @error('tanggal_masuk')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}">
                            @error('jumlah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal" type="button">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ================= EDIT MODAL ================= -->
    @foreach ($data as $item)
        <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('material_masuk.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="modal" value="edit-{{ $item->id }}">

                        <div class="modal-header">
                            <h5>Edit Material Masuk</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-2">
                                <label>Kawasan</label>
                                <select name="kawasan_id" class="form-control">
                                    @foreach ($kawasans as $kawasan)
                                        <option value="{{ $kawasan->id }}"
                                            {{ $item->kawasan_id == $kawasan->id ? 'selected' : '' }}>
                                            {{ $kawasan->nama_kawasan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label>Material</label>
                                <select name="material_id" class="form-control">
                                    @foreach ($materials as $m)
                                        <option value="{{ $m->id }}"
                                            {{ $item->material_id == $m->id ? 'selected' : '' }}>
                                            {{ $m->nama_material }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label>Supplier</label>
                                <select name="supplier_id" class="form-control">
                                    @foreach ($suppliers as $s)
                                        <option value="{{ $s->id }}"
                                            {{ $item->supplier_id == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal_masuk" class="form-control"
                                    value="{{ $item->tanggal_masuk }}">
                            </div>

                            <div class="mb-2">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" value="{{ $item->jumlah }}">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button class="btn btn-primary">Update</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endforeach

@endsection
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let modal = "{{ old('modal') }}";

            if (modal === "tambah") {
                let m = new bootstrap.Modal(document.getElementById('standard-modal'));
                m.show();

                setTimeout(function() {
                    $('#table').DataTable().columns.adjust();
                }, 100);
            }

            if (modal && modal.startsWith("edit-")) {
                let id = modal.replace("edit-", "");
                let m = new bootstrap.Modal(document.getElementById('edit-modal' + id));
                m.show();

                setTimeout(function() {
                    $('#table').DataTable().columns.adjust();
                }, 100);
            }

        });
    </script>
@endif
