    @extends('app')
    @section('title', 'Data User')

    @section('content')
        <div class="col">

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

                <!-- Default Modals -->
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
                                    <th scope="col" style="width: 1%">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" style="width: 10%">Role</th>
                                    <th scope="col" style="width: 5%">Status</th>
                                    <th style="width:1%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            @if ($user->status == 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-warning">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">


                                            <!-- EDIT -->
                                            <a href="#" class="btn btn-icon btn-sm bg-primary-subtle me-1"
                                                data-bs-toggle="modal" data-bs-target="#edit-modal{{ $user->id }}"
                                                title="Edit">
                                                <i class="mdi mdi-pencil-outline fs-14 text-primary"></i>
                                            </a>

                                            <!-- DELETE (khusus admin) -->
                                            @if (auth()->id() == 1)
                                                <a href="#" class="btn btn-icon btn-sm bg-danger-subtle"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}"
                                                    title="Hapus">
                                                    <i class="mdi mdi-delete fs-14 text-danger"></i>
                                                </a>
                                            @endif

                                            @if ($user->status == 'aktif')
                                                <form action="{{ route('user.nonaktif', $user->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button class="btn btn-warning btn-sm" title="Nonaktifkan user">
                                                        <i class="fa-solid fa-user-slash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('user.aktif', $user->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm" title="Aktifkan user">
                                                        <i class="fa-solid fa-user-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- form edit --}}

                                    <div class="modal fade" id="edit-modal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog ">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('user.update', $user->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="modal" value="edit-{{ $user->id }}">
                                                    <div class="modal-body">

                                                        <div class="row g-3">

                                                            <div class="">
                                                                <label class="form-label">Nama</label>
                                                                <input type="text" name="nama" placeholder="Nama"
                                                                    class="form-control @error('nama')
                                                                        is-invalid
                                                                    @enderror"
                                                                    value="{{ $user->nama }}" id="nama">

                                                                @error('nama')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="">
                                                                <label class="form-label">Email</label>
                                                                <input type="text" name="email" placeholder="Email"
                                                                    class="form-control @error('email')
                                                                        is-invalid
                                                                    @enderror"
                                                                    value="{{ $user->email }}" id="email">

                                                                @error('email')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="">
                                                                <label class="form-label">Password</label>
                                                                <input type="password" class="form-control" name="password"
                                                                    placeholder="Kosongkan jika tidak ingin mengganti password">
                                                            </div>

                                                            <div>
                                                                <label for="" class="form-label">Role</label>
                                                                <select name="role" id=""
                                                                    class="form-control @error('role')
                                                                    is-invalid
                                                                @enderror">
                                                                    <option value="">--Pilih Role--</option>
                                                                    <option value="admin"
                                                                        {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                                    </option>
                                                                    <option value="mandor"
                                                                        {{ $user->role == 'mandor' ? 'selected' : '' }}>Mandor
                                                                    </option>
                                                                </select>

                                                                @error('role')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                @enderror
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

                                    {{-- modal hapus --}}
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus user <b>{{ $user->nama }}</b> ?
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Batal</button>

                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
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
                                @endforeach

                            </tbody>
                        </table>

                        {{-- modal tambah --}}
                        <div class="modal fade" id="standard-modal" tabindex="-1">
                            <div class="modal-dialog ">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('user.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="modal" value="tambah">
                                            <div class="row g-3">

                                                <div class="">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="nama" placeholder="Nama"
                                                        class="form-control @error('nama')
                                                            is-invalid
                                                        @enderror"
                                                        value="{{ old('nama') }}" id="nama">

                                                    @error('nama')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" name="email" placeholder="Email"
                                                        class="form-control @error('email')
                                                            is-invalid
                                                        @enderror"
                                                        value="{{ old('email') }}" id="email">

                                                    @error('email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" placeholder="Password"
                                                        class="form-control @error('password')
                                                            is-invalid
                                                        @enderror ">

                                                    @error('password')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div>
                                                    <label for="" class="form-label">Role</label>
                                                    <select name="role" id=""
                                                        class="form-control @error('role')
                                                        is-invalid
                                                    @enderror">
                                                        <option value="">--Pilih Role--</option>
                                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                            Admin</option>
                                                        <option value="mandor"
                                                            {{ old('role') == 'mandor' ? 'selected' : '' }}>Mandor</option>
                                                    </select>
                                                    @error('role')
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
        @endsection

        @if ($errors->any())
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

                    // document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                    //     new bootstrap.Tooltip(el);
                    // });

                });
            </script>
        @endif
