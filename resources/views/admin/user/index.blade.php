@extends('app')

@section('content')
    <div class="col">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mt-3">

            <!-- Default Modals -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data user</h5>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
                    Tambah User
                </button>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 4%">No</th>
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
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#edit-modal{{ $user->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        @if (auth()->id() == 1)
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm""
                                                    onclick="return confirm('Yakin hapus user ini?')">

                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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
                                                <div class="modal-body">

                                                    <div class="row g-3">

                                                        <div class="">
                                                            <label class="form-label">Nama</label>
                                                            <input type="text" class="form-control" name="nama"
                                                                placeholder="nama" value="{{ $user->nama }}">
                                                        </div>

                                                        <div class="">
                                                            <label class="form-label">Email</label>
                                                            <input type="text" class="form-control" name="email"
                                                                placeholder="email" value="{{ $user->email }}">
                                                        </div>

                                                        <div class="">
                                                            <label class="form-label">Password</label>
                                                            <input type="password" class="form-control" name="password"
                                                                placeholder="Kosongkan jika tidak ingin mengganti password">
                                                        </div>

                                                        <div>
                                                            <label for="" class="form-label">Role</label>
                                                            <select name="role" id="" class="form-control">
                                                                <option value="admin"
                                                                    {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                                </option>
                                                                <option value="mandor"
                                                                    {{ $user->role == 'mandor' ? 'selected' : '' }}>Mandor
                                                                </option>
                                                            </select>
                                                        </div>

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

                                        <div class="row g-3">

                                            <div class="">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="nama"
                                                    placeholder="nama">
                                            </div>

                                            <div class="">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" name="email"
                                                    placeholder="email">
                                            </div>

                                            <div class="">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="Password"
                                                    placeholder="password">
                                            </div>

                                            <div>
                                                <label for="" class="form-label">Role</label>
                                                <select name="role" id="" class="form-control">
                                                    <option value="admin">Admin</option>
                                                    <option value="mandor">Mandor</option>
                                                </select>
                                            </div>

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
                </div>
            </div>
        </div>
    @endsection
