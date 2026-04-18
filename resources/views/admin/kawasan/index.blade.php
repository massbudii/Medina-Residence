@extends('app')
@section('title', 'Data Kawasan')
@section('content')

    <style>
        .type-box {
            max-height: 180px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background: #f9f9f9;
        }

        .type-box .form-check {
            margin-bottom: 6px;
        }

        .type-box .form-check:hover {
            background: #eef6ff;
        }
    </style>




    <div class="col">


        <div class="col">

            <div class="card mt-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Data Kawasan</h2>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                        Tambah Kawasan
                    </button>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" id="table">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 1%">No</th>
                                    <th scope="col">Nama Kawasan</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col" style="width: 10%">Type Unit</th>
                                    <th scope="col" style="width: 5%">Status</th>
                                    <th style="width:1%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_kawasan }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>
                                            @foreach ($item->typeUnits as $type)
                                                <span>{{ $type->nama_type }}</span>
                                            @endforeach
                                            @if ($item->typeUnits->isEmpty())
                                                <span class="text-muted">Belum ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-warning">Selesai</span>
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
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}"
                                                title="Hapus">
                                                <i class="mdi mdi-delete fs-14 text-danger"></i>
                                            </a>

                                            @if ($item->status == 'aktif')
                                                <form action="{{ route('kawasan.selesai', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        Selesai
                                                    </button>
                                                </form>
                                            @elseif ($item->status == 'selesai')
                                                <form action="{{ route('kawasan.aktif', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Aktifkan
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kawasan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('kawasan.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="modal" value="edit-{{ $item->id }}">

                                                    <div class="modal-body">
                                                        <div class="row g-3">

                                                            <div class="">
                                                                <label class="form-label">Nama Kawasan</label>
                                                                <input type="text" name="nama_kawasan"
                                                                    class="form-control @error('nama_kawasan') is-invalid @enderror"
                                                                    value="{{ $item->nama_kawasan }}">
                                                                @error('nama_kawasan')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="">
                                                                <label class="form-label">Alamat</label>
                                                                <input type="text" name="alamat"
                                                                    class="form-control @error('alamat') is-invalid @enderror"
                                                                    value="{{ $item->alamat }}">
                                                                @error('alamat')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            {{-- <div>
                                                            <label class="form-label">Status</label>
                                                            <select name="status"
                                                                class="form-control @   error('status') is-invalid @enderror">

                                                                <option value="aktif"
                                                                    {{ $item->status == 'aktif' ? 'selected' : '' }}>
                                                                    Aktif
                                                                </option>

                                                                <option value="selesai"
                                                                    {{ $item->status == 'selesai' ? 'selected' : '' }}>
                                                                    Selesai
                                                                </option>

                                                            </select>

                                                            @error('status')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div> --}}

                                                            <div>
                                                                <label class="form-label">Type Unit</label>

                                                                <div class="type-box">
                                                                    @foreach ($types as $type)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                name="type_unit_id[]"
                                                                                value="{{ $type->id }}"
                                                                                id="type{{ $type->id }}"
                                                                                {{ in_array($type->id, (array) old('type_unit_id', $item->typeUnits->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>

                                                                            <label class="form-check-label"
                                                                                for="type{{ $type->id }}">
                                                                                {{ $type->nama_type }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>

                                                                @error('type_unit_id')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus kawasan
                                                    <b>{{ $item->nama_kawasan }}</b>
                                                    ?
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Batal</button>

                                                    <form action="{{ route('kawasan.delete', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Modal Tambah -->
                        <div class="modal fade" id="standard-modal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Kawasan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('kawasan.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="modal" value="tambah">

                                        <div class="modal-body">
                                            <div class="row g-3">

                                                <div class="">
                                                    <label class="form-label">Nama Kawasan</label>
                                                    <input type="text" name="nama_kawasan"
                                                        placeholder="Contoh: Kawasan Griya Asri"
                                                        class="form-control @error('nama_kawasan') is-invalid @enderror"
                                                        value="{{ old('nama_kawasan') }}">
                                                    @error('nama_kawasan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="">
                                                    <label class="form-label">Alamat</label>
                                                    <input type="text" name="alamat"
                                                        class="form-control @error('alamat') is-invalid @enderror"
                                                        value="{{ old('alamat') }}">
                                                    @error('alamat')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="">
                                                    <label class="form-label">Status</label>
                                                    <select name="status"
                                                        class="form-control @error('status') is-invalid @enderror">
                                                        <option value="">--Pilih Status--</option>
                                                        <option value="Aktif"
                                                            {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Nonaktif"
                                                            {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                                        </option>
                                                    </select>
                                                    @error('status')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label class="form-label">Type Unit</label>

                                                    <div class="type-box">
                                                        @foreach ($types as $type)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="type_unit_id[]" value="{{ $type->id }}"
                                                                    id="type_add{{ $type->id }}"
                                                                    {{ in_array($type->id, (array) old('type_unit_id')) ? 'checked' : '' }}>

                                                                <label class="form-check-label"
                                                                    for="type_add{{ $type->id }}">
                                                                    {{ $type->nama_type }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    @error('type_unit_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
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

    @if ($errors->any() && old('modal'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                let modal = "{{ old('modal') }}";

                if (modal === "tambah") {
                    new bootstrap.Modal(document.getElementById('standard-modal')).show();
                }

                if (modal.startsWith("edit-")) {
                    let id = modal.replace("edit-", "");
                    new bootstrap.Modal(document.getElementById('edit-modal' + id)).show();
                }
                $(document).ready(function() {
                    $('.select2').select2({
                        placeholder: "Pilih Type Unit",
                        width: '100%'
                    });
                });

            });
        </script>
    @endif
