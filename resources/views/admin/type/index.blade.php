@extends('app')
@section('content')
    <div class="col">

        @if (session('success'))
            <div class="alert alert-success mt-2" id="success-alert" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger  mt-2" id="danger-alert" role="alert">
                {{ session('error') }}
            </div>
        @endif


        <div class="card mt-3">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Data Type Unit</h2>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                    Tambah Type
                </button>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Type </th>
                                <th>Luas Banguanan</th>
                                <th>Luas tanah</th>
                                <th>Harga Rumah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        @foreach ($type as $key => $item)

                            <tbody>

                                <tr>
                                    <th scope="row" >{{ $loop->iteration }}</th>
                                    <td>{{ $item->nama_type }}</td>
                                    <td>{{ $item->luas_bangunan }} m<sup>2</sup> </td>
                                    <td>{{ $item->luas_tanah }} m<sup>2</sup> </td>
                                    <td>{{ $item->harga_rumah }}</td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#edit-modal1">
                                            Edit
                                        </button>

                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal1">
                                            Hapus
                                        </button>

                                        <button class="btn btn-warning btn-sm">
                                            Nonaktifkan
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        @endforeach

                    </table>

                    <!-- MODAL EDIT -->
                    <div class="modal fade" id="edit-modal1" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form>
                                    <div class="modal-body">

                                        <div class="row g-3">

                                            <div>
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control" value="Admin Utama">
                                            </div>

                                            <div>
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" value="admin@mail.com">
                                            </div>

                                            <div>
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control">
                                            </div>

                                            <div>
                                                <label class="form-label">Role</label>
                                                <select class="form-control">
                                                    <option>Admin</option>
                                                    <option>Mandor</option>
                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-primary">Update</button>
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
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>

                                    <button class="btn btn-danger">
                                        Hapus
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- MODAL TAMBAH -->
                    <div class="modal fade" id="standard-modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('type.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="row g-3">

                                            <div>
                                                <label class="form-label">Nama Type</label>
                                                <input type="text" class="form-control" name="nama_type">
                                            </div>

                                            <div>
                                                <label class="form-label">Luas Bangunan</label>
                                                <input type="text" class="form-control" name="luas_bangunan">
                                            </div>

                                            <div>
                                                <label class="form-label">Luas Tanah</label>
                                                <input type="number" class="form-control" name="luas_tanah">
                                            </div>

                                            <div>
                                                <label class="form-label">Harga Rumah</label>
                                                <input type="number" class="form-control" name="harga_rumah">
                                            </div>


                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
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
