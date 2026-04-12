@extends('app')
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

                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#edit-modal{{ $item->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal1{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

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

                                                        <input type="text" name="nama_type" class="form-control"
                                                            value="{{ $item->nama_type }}">

                                                        @error('nama_type')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Luas Bangunan</label>
                                                        <input type="number" name="luas_bangunan" class="form-control"
                                                            value="{{ $item->luas_bangunan }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Luas Tanah</label>
                                                        <input type="number" name="luas_tanah" class="form-control"
                                                            value="{{ $item->luas_tanah }}">
                                                    </div>

                                                    <div>
                                                        <label class="form-label">Harga Rumah</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="number" name="harga_rumah" class="form-control" value="{{ $item->harga_rumah }}">
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

                                <!-- MODAL DELETE -->
                                <div class="modal fade" id="deleteModal1" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus user <b>Admin Utama</b> ?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Batal</button>

                                                <button class="btn btn-danger">
                                                    Hapus
                                                </button>
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
                                                <input type="text" class="form-control" name="nama_type"
                                                    placeholder="Contoh: Type 45">

                                                @error('nama_type')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="form-label">Luas Bangunan</label>
                                                <input type="text" class="form-control" name="luas_bangunan">

                                                @error('luas_bangunan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="form-label">Luas Tanah</label>
                                                <input type="number" class="form-control" name="luas_tanah">

                                                @error('luas_tanah')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="form-label">Harga Rumah</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" name="harga" class="form-control">
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
                }, 300);
            }

            if (modal && modal.startsWith("edit-")) {
                let id = modal.replace("edit-", "");
                let m = new bootstrap.Modal(document.getElementById('edit-modal' + id));
                m.show();

                setTimeout(function() {
                    $('#table').DataTable().columns.adjust();
                }, 300);
            }

        });
    </script>
@endif
