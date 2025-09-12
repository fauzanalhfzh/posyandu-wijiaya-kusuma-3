<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemeriksaan Kesehatan Ibu</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12pt;
            margin: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .info p {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11pt;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px;
        }

        td {
            vertical-align: top;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 10pt;
        }

        .ttd {
            margin-top: 60px;
            text-align: right;
            font-size: 11pt;
        }
    </style>
</head>

<body>
    <h2>Laporan Pemeriksaan Kesehatan Ibu</h2>

    <div class="info">
        <p><strong>Nama Ibu:</strong> {{ $ibu->nama_lengkap }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($ibu->tgl_lahir)->format('d F Y') }}</p>
    </div>

    <p><strong>Riwayat Pemeriksaan Kesehatan Ibu</strong></p>

    <table>
        <thead>
            <tr>
                <th>Tanggal Pemeriksaan</th>
                <th>Keluhan</th>
                <th>Tinggi Badan (cm)</th>
                <th>Berat Badan (kg)</th>
                <th>Tekanan Darah (mmHg)</th>
                <th>Usia Ibu (tahun)</th>
                <th>Usia Kehamilan (minggu)</th>
                <th>Tinggi Fundus (cm)</th>
                <th>Letak Janin</th>
                <th>Denyut Jantung Janin (bpm)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ibu->pemeriksaanIbu as $pemeriksaan)
            <tr>
                <td>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                <td>{{ $pemeriksaan->keluhan }}</td>
                <td>{{ $pemeriksaan->tinggi_badan }}</td>
                <td>{{ $pemeriksaan->berat_badan }}</td>
                <td>{{ $pemeriksaan->tekanan_darah }}</td>
                <td>{{ $pemeriksaan->usia_ibu }}</td>
                <td>{{ $pemeriksaan->usia_kehamilan }}</td>
                <td>{{ $pemeriksaan->tinggi_fundus }}</td>
                <td>{{ $pemeriksaan->letak_janin }}</td>
                <td>{{ $pemeriksaan->denyut_jantung_janin }}</td>
                <td>{{ $pemeriksaan->keterangan ?? 'Tidak Ada Keterangan' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd">
        <p>{{ now()->format('d F Y') }}</p>
        <p><strong>Bidan Pemeriksa</strong></p>
        <br><br><br>
        @if($ibu->pemeriksaanIbu->isNotEmpty())
        <p><u>{{ $ibu->pemeriksaanIbu->first()->bidan->nama_lengkap }}</u></p>
        @else
        <p>Data Bidan Tidak Tersedia</p>
        @endif
    </div>
</body>

</html>