@extends('app')
@section('title', ' Type Unit')
@section('content')
    <div class="col">

        <div class="card mt-3">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Data Type Unit</h2>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                    Tambah Type
                </button>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-start" id="table">
                        <thead>
                            <tr>
                                <th style=" width: 1%">No</th>
                                <th class="text-start sorting">Nama Type </th>
                                <th>Luas Banguanan</th>
                                <th>Luas tanah</th>
                                <th>Harga Rumah</th>
                                <th class="text-center" style="width: 4%">Aksi</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($type as $key => $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="text-start sorting">{{ $item->nama_type }}</td>
                                    <td>{{ $item->luas_bangunan }} m<sup>2</sup> </td>
                                    <td>{{ $item->luas_tanah }} m<sup>2</sup> </td>
                                    <td>Rp {{ number_format($item->harga_rumah, 0, ',', '.') }}</td>
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

                                    </td>
                                </tr>

                                <div class="modal fade" id="edit-modal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Type Unit</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('type.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">

                                                    <input type="hidden" name="modal" value="edit-{{ $item->id }}">

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Type</label>

                                                        <input type="text" name="nama_type"
                                                            class="form-control @error('nama_type')
                                                            is-invalid
                                                        @enderror"
                                                            value="{{ $item->nama_type }}">

                                                        @error('nama_type')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Luas Bangunan</label>
                                                        <input type="number" name="luas_bangunan"
                                                            class="form-control @error('luas_bangunan')
                                                            is-invalid
                                                        @enderror"
                                                            value="{{ $item->luas_bangunan }}">
                                                        @error('luas_bangunan')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Luas Tanah</label>
                                                        <input type="number" name="luas_tanah"
                                                            class="form-control  @error('luas_tanah')
                                                            is-invalid
                                                        @enderror"
                                                            value="{{ $item->luas_tanah }}">

                                                        @error('luas_tanah')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="form-label">Harga Rumah</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="number" name="harga_rumah"
                                                                class="form-control  @error('harga_rumah')
                                                            is-invalid
                                                        @enderror"
                                                                value="{{ $item->harga_rumah }}">
                                                        </div>
                                                        @error('harga_rumah')
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
                                                Apakah anda yakin ingin menghapus <b>{{ $item->nama_type }}</b> ?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Batal</button>

                                                <form action="{{ route('type.delete', $item->id) }}" method="POST">
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

                                <form action="{{ route('type.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="modal" value="tambah">
                                        <div class="row g-3">

                                            <div>
                                                <label class="form-label">Nama Type</label>
                                                <input type="text" name="nama_type" placeholder="Contoh: Type 45"
                                                    class="form-control @error('nama_type')
                                                        is-invalid
                                                    @enderror"
                                                    value="{{ old('nama_type') }}" id="nama_type">

                                                @error('nama_type')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="form-label">Luas Bangunan</label>
                                                <input type="text" name="luas_bangunan"
                                                    class="form-control @error('luas_bangunan')
                                                    is-invalid
                                                @enderror"
                                                    value="{{ old('luas_bangunan') }}">
                                                @error('luas_bangunan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="form-label">Luas Tanah</label>
                                                <input type="number" name="luas_tanah"
                                                    class="form-control @error('luas_tanah')
                                                is-invalid
                                                @enderror"
                                                    value="{{ old('luas_tanah') }}">
                                                @error('luas_tanah')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="form-label">Harga Rumah</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" name="harga_rumah"
                                                        class="form-control @error('harga_rumah')
                                                        is-invalid
                                                    @enderror"
                                                        value="{{ old('harga_rumah') }}">
                                                </div>
                                                @error('harga_rumah')
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
