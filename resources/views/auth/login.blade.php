@extends('auth')
@section('content')

    <body>
        <!-- Begin page -->
        <div class="account-page"
            style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
     url('{{ asset('assets/images/rumah-medina.jpg') }}');
     background-size: cover; background-position: center;">
            >
            <div class="container-fluid p-0">
                <div class="row align-items-center justify-content-center g-0 px-3 py-3 vh-100">


                    <div class="col-xl-5 d-flex justify-content-center align-items-center">
                        <div class="row">
                            <div class="col-md mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-0 p-0 p-lg-3">
                                            <div class="mb-0 border-0 p-md-4 p-lg-0">
                                                <div class="mb-4 p-0 text-lg-start text-center">
                                                    <div class="auth-brand text-center">

                                                        @if (session('failed'))
                                                            <div class="alert alert-danger">
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
                                                    <p class="text-muted fs-14 mb-0">Silahkan log in untuk memulai pekerjaan
                                                        anda</p>
                                                </div>

                                                <div class="pt-0">
                                                    <form action="{{ route('login') }}" method="POST" class="my-4">
                                                        @csrf


                                                        <div class="form-group mb-3">
                                                            <label for="emailaddress" class="form-label">Email</label>
                                                            <input class="form-control" type="email" id="emailaddress"
                                                                placeholder="Masukkan email anda" name="email">
                                                            @error('email')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror

                                                            <div class="invalid-feedback">
                                                                salah
                                                            </div>

                                                        </div>


                                                        <div class="form-group mb-3 >
                                                            <label for="password"
                                                            class="form-label">Password</label>
                                                            <input class="form-control" type="password" id="password"
                                                                placeholder="Masukkan password anda" name="password">

                                                            @error('password')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror

                                                            <div class="invalid-feedback">
                                                                salah
                                                            </div>

                                                        </div>

                                                        <div class="form-group mb-0 row">
                                                            <div class="col-12">
                                                                <div class="d-grid">
                                                                    <button class="btn btn-primary fw-semibold"
                                                                        type="submit"> Log In </button>
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
    @endsection
