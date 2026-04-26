@extends('app')
@section('title', 'Data Laporan')

@section('content')
<div class="col">

<div class="card mt-3">
    <div class="card-header">
        <h4>Data Material</h4>
    </div>

    <div class="card-body">

        {{-- FILTER --}}
        <form method="GET">
            <div class="row mb-3">

                <div class="col-md-4">
                    <select name="kawasan_id" class="form-control">
                        <option value="">-- Kawasan --</option>
                        @foreach ($kawasans as $k)
                            <option value="{{ $k->id }}"
                                {{ request('kawasan_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kawasan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="date" name="dari" class="form-control"
                        value="{{ request('dari') }}">
                </div>

                <div class="col-md-3">
                    <input type="date" name="sampai" class="form-control"
                        value="{{ request('sampai') }}">
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('laporan.data') }}" class="btn btn-warning w-100">Reset</a>
                </div>

            </div>
        </form>

        {{-- TABLE --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kawasan</th>
                    <th>Material</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Stok</th>
                </tr>
            </thead>

            <tbody>
                @if(!$isFilter)
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Silakan filter dulu
                        </td>
                    </tr>
                @else
                    @forelse($data as $d)
                        <tr>
                            <td>{{ $d->tanggal }}</td>
                            <td>{{ $d->kawasan->nama_kawasan }}</td>
                            <td>{{ $d->material->nama_material }}</td>
                            <td>{{ $d->tipe == 'masuk' ? $d->jumlah : '-' }}</td>
                            <td>{{ $d->tipe == 'keluar' ? $d->jumlah : '-' }}</td>
                            <td><b>{{ $d->stok }}</b></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Data tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>

    </div>
</div>

</div>
@endsection
