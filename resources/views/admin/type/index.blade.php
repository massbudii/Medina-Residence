@extends('app')
@section('content')


<div class="col">

    <div class="alert alert-success mt-2" id="success-alert" role="alert">
        Success message
    </div>

    <div class="alert alert-danger mt-2" id="danger-alert" role="alert">
        Error message
    </div>

    <div class="modal fade" id="alert-admin" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Peringatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Admin utama tidak bisa diedit.
                </div>

            </div>
        </div>
    </div>

    <div class="card mt-3">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">Data User</h2>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                Tambah User
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered mb-0" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><span class="badge bg-success"></span></td>
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
                                    <button type="button" class="btn btn-light"
                                        data-bs-dismiss="modal">Batal</button>
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
                                <button type="button" class="btn-close"
                                    data-bs-dismiss="modal"></button>
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

                <!-- MODAL TAMBAH -->
                <div class="modal fade" id="standard-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Tambah User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form>
                                <div class="modal-body">

                                    <div class="row g-3">

                                        <div>
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control">
                                        </div>

                                        <div>
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control">
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
