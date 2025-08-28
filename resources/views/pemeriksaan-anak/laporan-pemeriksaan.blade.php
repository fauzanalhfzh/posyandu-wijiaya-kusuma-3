<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemeriksaan Kesehatan Anak</title>
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
    <h2>Laporan Pemeriksaan Kesehatan Anak</h2>

    <div class="info">
        <p><strong>Nama Anak:</strong> {{ $anak->nama_lengkap }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($anak->tgl_lahir)->format('d F Y') }}</p>
        <p><strong>Nama Ibu:</strong> {{ $anak->ibu->nama_lengkap }}</p>
    </div>

    <p><strong>Riwayat Pemeriksaan Kesehatan Anak</strong></p>

    <table>
        <thead>
            <tr>
                <th>Tanggal Pemeriksaan</th>
                <th>Usia (bulan)</th>
                <th>Berat Badan (kg)</th>
                <th>Jenis Imunisasi</th>
                <th>Jenis Vitamin</th>
                <th>Saran Bidan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anak->pemeriksaanAnak as $pemeriksaan)
            <tr>
                <td>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                <td>{{ $pemeriksaan->usia_balita }}</td>
                <td>{{ $pemeriksaan->berat_badan }}</td>
                <td>{{ $pemeriksaan->imunisasi->jenis_imunisasi }}</td>
                <td>{{ $pemeriksaan->vitamin->jenis_vitamin }}</td>
                <td>{{ $pemeriksaan->saran ?? 'Tidak Ada Saran' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd">
        <p>{{ now()->format('d F Y') }}</p>
        <p><strong>Bidan Pemeriksa</strong></p>
        <br><br><br>
        <p><u>{{ $anak->pemeriksaanAnak->first()->bidan->nama_lengkap }}</u></p>
    </div>
</body>

</html>