@extends('app')
@section('title', 'Profil Pengguna')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Card Profil Formal -->
            <div class="col-lg-4">
                <div class="card text-center p-3 shadow-sm">
                    <div class="card-body">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ $user->foto ? asset($user->foto) : asset('assets/images/users/avatar-1.jpg') }}"
                                alt="Foto Profil" class="rounded-circle img-thumbnail shadow-sm"
                                style="width: 130px; height: 130px; object-fit: cover;" id="profileImagePreview">
                        </div>
                        <h4 class="mb-1 text-dark fw-bold">{{ $user->nama }}</h4>
                        <p class="text-muted mb-2">{{ $user->email }}</p>

                        <div class="mb-3">
                            @if ($user->role == 'admin')
                                <span class="badge bg-primary fs-13 px-3 py-1">Admin</span>
                            @else
                                <span class="badge bg-info fs-13 px-3 py-1">Mandor</span>
                            @endif

                            @if ($user->status == 'aktif')
                                <span class="badge bg-success fs-13 px-3 py-1">Akun Aktif</span>
                            @else
                                <span class="badge bg-danger fs-13 px-3 py-1">Nonaktif</span>
                            @endif
                        </div>

                        <ul class="list-group list-group-flush text-start border-top pt-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <span class="text-muted"><i class="fa-solid fa-phone me-2"></i>No. HP</span>
                                <span class="fw-semibold">{{ $user->no_hp ?? '-' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                <span class="text-muted"><i class="fa-solid fa-calendar me-2"></i>Terdaftar Sejak</span>
                                <span class="fw-semibold">{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Form Edit Profil Formal -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fa-solid fa-user-gear me-2 fs-18"></i>
                        <h5 class="card-title mb-0 text-white">Pengaturan Profil Pengguna</h5>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $user->nama) }}" placeholder="Masukkan nama lengkap">
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" placeholder="Masukkan alamat email">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nomor HP / WhatsApp</label>
                                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                        value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 08123456789">
                                    @error('no_hp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Upload Foto Profil Baru</label>
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                        accept="image/*" onchange="previewFile(this)">
                                    <small class="text-muted">Format: JPG, PNG, GIF (Maks. 2MB)</small>
                                    @error('foto')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12"><hr class="my-2"></div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Password Baru (Opsional)</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Kosongkan jika tidak ingin mengubah password" autocomplete="new-password">
                                    <small class="text-muted d-block mt-1 fs-12">Format: Diawali huruf kapital & mengandung kombinasi huruf + angka (contoh: Admin123)</small>
                                    @error('password')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert Wajib Lengkapi Profil -->
    @if (session('wajib_isi_profil') || session('warning'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Wajib Lengkapi Profil!',
                        text: "{{ session('warning') ?? 'Silahkan lengkapi data profil dan upload foto Anda terlebih dahulu.' }}",
                        icon: 'warning',
                        confirmButtonText: 'Saya Mengerti',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        </script>
    @endif

    <script>
        function previewFile(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function () {
                    document.getElementById("profileImagePreview").src = reader.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
