@extends('app')
@section('title', 'Pengajuan Laporan')

@section('content')
    <div class="col">


        {{-- ================= FORM AJUKAN (MANDOR SAJA) ================= --}}
        @if (auth()->user()->role == 'mandor')
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Ajukan Laporan</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('laporan.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Kawasan</label>
                                <select name="kawasan_id" class="form-control @error('kawasan_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kawasan --</option>
                                    @foreach ($kawasans as $k)
                                        <option value="{{ $k->id }}"
                                            {{ old('kawasan_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kawasan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kawasan_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="dari"
                                    class="form-control @error('dari') is-invalid @enderror" value="{{ old('dari') }}">
                                @error('dari')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="sampai"
                                    class="form-control @error('sampai') is-invalid @enderror" value="{{ old('sampai') }}">
                                @error('sampai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-primary w-100">
                                    Ajukan
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        @endif



        {{-- ================= TABLE PENGAJUAN ================= --}}
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Data Pengajuan Laporan</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="table">
                        <thead>
                            <tr>
                                <th style="width:1%">No</th>
                                <th>Kawasan</th>
                                <th>Periode</th>
                                <th>Dibuat Oleh</th>
                                <th>Disetujui Oleh</th>
                                <th>Status</th>
                                <th style="width:1%" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($laporans as $l)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $l->kawasan->nama_kawasan ?? '-' }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($l->dari)->format('d-m-Y') }}
                                        s/d
                                        {{ \Carbon\Carbon::parse($l->sampai)->format('d-m-Y') }}
                                    </td>

                                    <td>{{ $l->pembuat->nama ?? '-' }}</td>

                                    <td>{{ $l->penyetuju->nama ?? '-' }}</td>

                                    <td>
                                        @if ($l->status == 'diajukan')
                                            <span class="badge bg-warning">Diajukan</span>
                                        @elseif($l->status == 'disetujui')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>

                                    <td class="text-nowrap text-center">


                                        {{-- ADMIN --}}
                                        @if (auth()->user()->role == 'admin')
                                            @if ($l->status == 'diajukan')
                                                <a href="{{ route('laporan.approve', $l->id) }}"
                                                    class="btn btn-success btn-sm btn-acc">
                                                    ACC
                                                </a>

                                                <a href="{{ route('laporan.reject', $l->id) }}"
                                                    class="btn btn-danger btn-sm btn-tolak">
                                                    Tolak
                                                </a>
                                            @elseif ($l->status == 'disetujui')
                                                <a href="{{ route('laporan.reject', $l->id) }}"
                                                    class="btn btn-danger btn-sm btn-tolak">
                                                    Tolak
                                                </a>
                                            @elseif ($l->status == 'ditolak')
                                                <a href="{{ route('laporan.approve', $l->id) }}"
                                                    class="btn btn-success btn-sm btn-acc">
                                                    ACC
                                                </a>
                                            @endif
                                        @endif
                                        {{-- MANDOR --}}
                                        @if (auth()->user()->role == 'mandor')
                                            @if ($l->status == 'disetujui')
                                                <a href="{{ route('laporan.print', $l->id) }}" target="_blank"
                                                    class="btn btn-primary btn-sm">
                                                    Print
                                                </a>
                                            @elseif ($l->status == 'ditolak')
                                                <button class="btn btn-danger btn-sm" disabled>
                                                    Ditolak
                                                </button>
                                            @else
                                                <button class="btn btn-warning btn-sm" disabled>
                                                    Menunggu ACC
                                                </button>
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <script>
        document.querySelectorAll('.btn-tolak').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                let url = this.getAttribute('href');

                Swal.fire({
                    title: 'Tolak Laporan?',
                    text: 'Status laporan akan diubah menjadi ditolak.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });

        document.querySelectorAll('.btn-acc').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                let url = this.getAttribute('href');

                Swal.fire({
                    title: 'Setujui Laporan?',
                    text: 'Status laporan akan diubah menjadi disetujui.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ACC',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

@endsection
