@extends('app')
@section('title', 'Material')

@section('content')
    <div class="col">

        <div class="card mt-3">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Data Material</h2>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                    Tambah Material
                </button>
            </div>

            <div class="card-body">

                <!-- FILTER -->
                <form method="GET" action="{{ route('material.index') }}">
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
                            <select name="type_unit_id" class="form-control">
                                <option value="">-- Filter Type Unit --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('type_unit_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->nama_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button class="btn btn-primary">Filter</button>
                            <a href="{{ route('material.index') }}" class="btn btn-warning">Reset</a>
                        </div>

                    </div>
                </form>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered text-start" id="table">
                        <thead>
                            <tr>
                                <th style="width: 1%">No</th>
                                <th>Nama Material</th>
                                <th style="width: 5%">Satuan</th>
                                <th style="width: 4%">Status</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($materials as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_material }}</td>
                                    <td>{{ $item->satuan }}</td>

                                    <td>
                                        @if ($item->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>

                                    <td class="text-nowrap">

                                        <!-- EDIT -->
                                        <a href="#" class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                            data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->id }}"
                                            title="Edit">
                                            <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                        </a>

                                        <!-- DELETE -->

                                        @if ($item->status == 'aktif')
                                            <form action="{{ route('material.nonaktif', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    Nonaktif
                                                </button>
                                            </form>
                                        @elseif ($item->status == 'nonaktif')
                                            <form action="{{ route('material.aktif', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Aktifkan
                                                </button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
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

                <form action="{{ route('material.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="modal" value="tambah">

                    <div class="modal-header">
                        <h5>Tambah Material</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-2">
                            <label>Nama Material</label>
                            <input type="text" name="nama_material" class="form-control"
                                value="{{ old('nama_material') }}">
                        </div>

                        <div class="mb-2">
                            <label>Satuan</label>
                            <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}">
                        </div>

                        <div class="mb-2">
                            <label>Kawasan</label>
                            <select name="kawasan_id" class="form-control">
                                <option value="">-- pilih --</option>
                                @foreach ($kawasans as $kawasan)
                                    <option value="{{ $kawasan->id }}">{{ $kawasan->nama_kawasan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label>Type Unit</label>
                            @foreach ($types as $type)
                                <div class="form-check">
                                    <input type="checkbox" name="type_unit_id[]" value="{{ $type->id }}">
                                    {{ $type->nama_type }}
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ================= EDIT MODAL ================= -->
    @foreach ($materials as $item)
        <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('material.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Material</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-2">
                                <label>Nama</label>
                                <input type="text" name="nama_material" class="form-control"
                                    value="{{ $item->nama_material }}">
                            </div>

                            <div class="mb-2">
                                <label>Satuan</label>
                                <input type="text" name="satuan" class="form-control" value="{{ $item->satuan }}">
                            </div>

                            <div class="mb-2">
                                <label>Kawasan</label>
                                <select name="kawasan_id" class="form-control">
                                    @foreach ($kawasans as $kawasan)
                                        <option value="{{ $kawasan->id }}">
                                            {{ $kawasan->nama_kawasan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label>Type Unit</label>

                                @php
                                    $selected = $item->materialKawasan->pluck('type_unit_id')->toArray();
                                @endphp

                                @foreach ($types as $type)
                                    <div class="form-check">
                                        <input type="checkbox" name="type_unit_id[]" value="{{ $type->id }}"
                                            {{ in_array($type->id, $selected) ? 'checked' : '' }}>
                                        {{ $type->nama_type }}
                                    </div>
                                @endforeach

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
