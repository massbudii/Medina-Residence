@extends('app')
@section('title', 'Supplier')
@section('content')
    <style>
        table td.text-start {
            text-align: left !important;
        }
    </style>
    <div class="col">

        <div class="card mt-3">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Data Supplier</h2>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                    Tambah Supplier
                </button>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-start" id="table">
                        <thead>
                            <tr>
                                <th style=" width: 1%">No</th>
                                <th class="text-start sorting">Nama Supplier </th>
                                <th>Alamat Supplier</th>
                                <th class="text-start">No Hp</th>
                                <th style="width: 1%">Status</th>
                                <th class="text-center" style="width: 4%">Aksi</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($supplier as $key => $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="text-start sorting">{{ $item->nama_supplier }}</td>
                                    <td>{{ $item->alamat_supplier }} </td>
                                    <td class="text-start text-nowrap   ">{{ $item->no_hp }} </td>
                                    <td>
                                        @if ($item->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-warning">Nonaktif </span>
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

                                        <a href="#" class="btn btn-icon btn-sm bg-danger-subtle"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal1{{ $item->id }}"
                                            title="Hapus">
                                            <i class="mdi mdi-delete fs-14 text-danger"></i>
                                        </a>

                                        @if ($item->status == 'aktif')
                                            <form action="{{ route('supplier.nonaktif', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    Nonaktif
                                                </button>
                                            </form>
                                        @elseif ($item->status == 'nonaktif')
                                            <form action="{{ route('supplier.aktif', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Aktifkan
                                                </button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>

                                <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Type Unit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('supplier.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">

                                                    <input type="hidden" name="modal" value="edit-{{ $item->id }}">

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Supplier</label>

                                                        <input type="text" name="nama_supplier"
                                                            class="form-control @error('nama_supplier')
                                                            is-invalid
                                                        @enderror"
                                                            value="{{ $item->nama_supplier }}">

                                                        @error('nama_supplier')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat Supplier</label>
                                                        <input type="text" name="alamat_supplier"
                                                            class="form-control @error('alamat_supplier')
                                                            is-invalid
                                                        @enderror"
                                                            value="{{ $item->alamat_supplier }}">
                                                        @error('alamat_supplier')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">No Hp</label>
                                                        <input type="text" name="no_hp"
                                                            class="form-control  @error('no_hp')
                                                            is-invalid
                                                        @enderror"
                                                            value="{{ $item->no_hp }}">

                                                        @error('no_hp')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                        Batal
                                                    </button>

                                                    <button type="submit" class="btn btn-primary">
                                                        Update
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <!-- MODAL HAPUS -->
                                <div class="modal fade" id="deleteModal1{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus <b>{{ $item->nama_supplier }}</b> ?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Batal</button>

                                                <form action="{{ route('supplier.delete', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger">
                                                        Hapus
                                                    </button>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>


                    <!-- MODAL TAMBAH -->
                    <div class="modal fade" id="standard-modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('supplier.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="modal" value="tambah">
                                        <div class="row g-3">

                                            <div>
                                                <label class="form-label">Nama Suplier</label>
                                                <input type="text" name="nama_supplier"
                                                    class="form-control @error('nama_supplier')
                                                        is-invalid
                                                    @enderror"
                                                    value="{{ old('nama_supplier') }}" id="nama_supplier">

                                                @error('nama_supplier')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="form-label">Alamat Supplier</label>
                                                <input type="text" name="alamat_supplier"
                                                    class="form-control @error('alamat_supplier')
                                                    is-invalid
                                                @enderror"
                                                    value="{{ old('alamat_supplier') }}">
                                                @error('alamat_supplier')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="form-label">No Hp</label>
                                                <input type="text" name="no_hp"
                                                    class="form-control @error('no_hp')
                                                is-invalid
                                                @enderror"
                                                    value="{{ old('no_hp') }}">
                                                @error('no_hp')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
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
