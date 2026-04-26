<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            size: A4 portrait;
        }

        body {
            font-family: Arial;
            font-size: 12px;
            margin: 40px;
        }

        /* WATERMARK FIX */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('assets/images/logo-medina-new.png') }}') repeat;
            background-size: 120px;
            opacity: 0.04;
            z-index: -1;
        }

        .header {
            text-align: center;
        }

        .header img {
            width: 80px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        hr {
            border: 1px solid black;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
        }

        th {
            background: #eee;
        }

        .text-center {
            text-align: center;
        }

        /* TTD FIX */
        .ttd {
            margin-top: 100px;
            width: 100%;
        }

        .ttd td {
            width: 50%;
            vertical-align: top;
        }

        .ttd-box {
            height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* bikin atas & bawah sejajar */
        }

        .ttd-top {
            text-align: center;
            font-weight: bold;
        }

        .ttd-top-right {
            text-align: left;
            /* tanggal rata kiri */
            margin-bottom: 5px;
        }

        .ttd-bottom {
            text-align: center;
        }

        .line {
            border-bottom: 1px solid black;
            width: 250px;
            margin: 0 auto 5px auto;
        }
    </style>
</head>

<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <img src="{{ asset('assets/images/logo-medina-new.png') }}">
        <h2>PT MEDINA AQSA ARTHATAMA</h2>
        <p>Jalan Sultan Syarif Kasim No 83 Kel Buluh Kasap Kec Dumai Timur</p>
    </div>

    <hr>

    <!-- TITLE -->
    <div class="title">
        LAPORAN MATERIAL
    </div>

    <!-- INFO -->
    <div class="info">
        Kawasan : {{ $kawasan->nama_kawasan ?? '-' }} <br>
        Periode :
        {{ \Carbon\Carbon::parse($dari)->translatedFormat('d F Y') }}
        -
        {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Tanggal</th>
                <th>Material</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Satuan</th>
                <th>Stok</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                    </td>

                    <td>{{ $item->material->nama_material }}</td>

                    <td class="text-center">
                        {{ $item->tipe == 'masuk' ? $item->jumlah : '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->tipe == 'keluar' ? $item->jumlah : '-' }}
                    </td>

                    <td class="text-center">
                        {{ $item->material->satuan }}
                    </td>

                    <td class="text-center">
                        <b>{{ $item->stok }}</b>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TTD -->
    <table class="ttd">
        <tr>
            <!-- KIRI -->
            <td>
                <div class="ttd-box">
                    <div class="ttd-top">
                        DIBUAT OLEH
                    </div>

                    <div class="ttd-bottom">
                        <div class="line"></div>
                        <b>{{ $dibuat->nama ?? '-' }}</b><br>
                        {{ ucfirst($dibuat->role ?? 'mandor') }}
                    </div>
                </div>
            </td>

            <!-- KANAN -->
            <td>
                <div class="ttd-box">
                    <div class="ttd-top text-center">
                        DISETUJUI OLEH
                    </div>

                    <div class="ttd-bottom">
                        <div class="line"></div>
                        <b>{{ $disetujui->nama ?? '-' }}</b><br>
                        {{ ucfirst($disetujui->role ?? '-') }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
