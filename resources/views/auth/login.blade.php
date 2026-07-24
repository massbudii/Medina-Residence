@extends('auth')
@section('content')

    <body>
        @php
            $lockoutSeconds = session('lockout_seconds');
        @endphp

        <!-- Begin page -->
        <div class="account-page"
            style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
     url('{{ asset('assets/images/rumah-medina.jpg') }}');
     background-size: cover; background-position: center;">
            
            <div class="container-fluid p-0">
                <div class="row align-items-center justify-content-center g-0 px-3 py-3 vh-100">

                    <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-7 col-sm-9 d-flex justify-content-center align-items-center">
                        <div class="row w-100 justify-content-center">
                            <div class="col-12">
                                <div class="card shadow-lg border-0 rounded-3" style="max-width: 420px; margin: 0 auto;">
                                    <div class="card-body">
                                        <div class="mb-0 p-0 p-lg-3">
                                            <div class="mb-0 border-0 p-md-4 p-lg-0">
                                                <div class="mb-4 p-0 text-lg-start text-center">
                                                    <div class="auth-brand text-center">

                                                        @if (session('failed'))
                                                            <div class="alert alert-danger" id="lockoutAlert">
                                                                {{ session('failed') }}
                                                            </div>
                                                        @endif

                                                        <a href="" class="logo logo-light">
                                                            <span class="logo-lg">
                                                                <img src="{{ asset('assets/images/logo-medina.jpg') }}"
                                                                    alt="" height="80">
                                                            </span>
                                                        </a>
                                                        <a href="" class="logo logo-dark">
                                                            <span class="logo-lg">
                                                                <img src="{{ asset('assets/images/logo-medina.jpg') }}"
                                                                    alt="" height="80">
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="auth-title-section mb-4 text-lg-start text-center">
                                                    <h3 class="text-dark fw-semibold mb-3 text-center">Selamat Datang</h3>
                                                    <p class="text-muted fs-14 mb-0">Silahkan log in untuk memulai pekerjaan anda</p>
                                                </div>

                                                <div class="pt-0">
                                                    <form action="{{ route('login') }}" method="POST" class="my-4" autocomplete="off">
                                                        @csrf

                                                        <div class="form-group mb-3">
                                                            <label for="emailaddress" class="form-label">Email</label>
                                                            <input class="form-control" type="email" id="emailaddress"
                                                                placeholder="Masukkan email anda" name="email" value="{{ old('email') }}"
                                                                readonly onfocus="this.removeAttribute('readonly');"
                                                                autocomplete="username" {{ $lockoutSeconds ? 'disabled' : '' }}>
                                                            @error('email')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="password" class="form-label">Password</label>
                                                            <input class="form-control" type="password" id="password"
                                                                placeholder="Masukkan password anda" name="password"
                                                                readonly onfocus="this.removeAttribute('readonly');"
                                                                autocomplete="current-password" {{ $lockoutSeconds ? 'disabled' : '' }}>

                                                            @error('password')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group mt-4 pt-2 mb-2 row">
                                                            <div class="col-12">
                                                                <div class="d-grid">
                                                                    <button class="btn btn-primary fw-semibold py-2" id="loginBtn"
                                                                        type="submit" {{ $lockoutSeconds ? 'disabled' : '' }}> Log In </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($lockoutSeconds)
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let remainingSeconds = {{ $lockoutSeconds }};
                    let alertBox = document.getElementById('lockoutAlert');
                    let emailInput = document.getElementById('emailaddress');
                    let passwordInput = document.getElementById('password');
                    let loginBtn = document.getElementById('loginBtn');

                    let interval = setInterval(function () {
                        remainingSeconds--;
                        if (remainingSeconds > 0) {
                            if (alertBox) {
                                alertBox.innerText = `Terlalu banyak percobaan login yang gagal. Silakan tunggu ${remainingSeconds} detik lagi.`;
                            }
                        } else {
                            clearInterval(interval);
                            if (alertBox) {
                                alertBox.className = 'alert alert-info';
                                alertBox.innerText = 'Waktu tunggu selesai. Silakan coba login kembali.';
                            }
                            if (emailInput) emailInput.disabled = false;
                            if (passwordInput) passwordInput.disabled = false;
                            if (loginBtn) loginBtn.disabled = false;
                        }
                    }, 1000);
                });
            </script>
        @endif
    @endsection
