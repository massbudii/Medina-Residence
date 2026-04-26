@extends('app')
@section('title', 'Pengajuan Laporan')

@section('content')
<div class="col">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif


    {{-- ================= FORM AJUKAN (MANDOR SAJA) ================= --}}
    @if(auth()->user()->role == 'mandor')
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
                        <select name="kawasan_id"
                            class="form-control @error('kawasan_id') is-invalid @enderror">
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
                            class="form-control @error('dari') is-invalid @enderror"
                            value="{{ old('dari') }}">
                        @error('dari')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="sampai"
                            class="form-control @error('sampai') is-invalid @enderror"
                            value="{{ old('sampai') }}">
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
                <table class="table table-bordered table-striped align-middle">

                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Kawasan</th>
                            <th>Periode</th>
                            <th>Dibuat Oleh</th>
                            <th>Disetujui Oleh</th>
                            <th>Status</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($laporans as $l)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>{{ $l->kawasan->nama_kawasan ?? '-' }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($l->dari)->format('d-m-Y') }}
                                s/d
                                {{ \Carbon\Carbon::parse($l->sampai)->format('d-m-Y') }}
                            </td>

                            <td>{{ $l->pembuat->nama ?? '-' }}</td>

                            <td>{{ $l->penyetuju->nama ?? '-' }}</td>

                            <td class="text-center">
                                @if($l->status == 'diajukan')
                                    <span class="badge bg-warning">Diajukan</span>
                                @elseif($l->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>

                            <td class="text-center">

                                {{-- ================= ADMIN ================= --}}
                                @if(auth()->user()->role == 'admin')

                                    @if($l->status == 'diajukan')
                                        <a href="{{ route('laporan.approve', $l->id) }}"
                                           class="btn btn-success btn-sm">
                                            ACC
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            Selesai
                                        </button>
                                    @endif

                                @endif


                                {{-- ================= MANDOR ================= --}}
                                @if(auth()->user()->role == 'mandor')

                                    @if($l->status == 'disetujui')
                                        <a href="{{ route('laporan.print', $l->id) }}"
                                           target="_blank"
                                           class="btn btn-primary btn-sm">
                                            Print
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            Menunggu ACC
                                        </button>
                                    @endif

                                @endif

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada pengajuan
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
@endsection
