<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemeriksaan Anak</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11pt;
            margin: 20px;
            color: #333;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .statistik {
            margin: 20px 0;
        }

        .statistik table {
            width: 100%;
            margin-bottom: 20px;
        }

        .statistik td {
            padding: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Laporan Pemeriksaan Anak</h2>
    <h4>Posyandu Wijaya Kusuma 3</h4>

    <div class="statistik">
        <h4>Statistik</h4>
        <table>
            <tr>
                <td><strong>Total Pemeriksaan:</strong></td>
                <td>{{ $total }}</td>
            </tr>
            <tr>
                <td><strong>Rata-rata Berat Badan:</strong></td>
                <td>{{ number_format($avgBerat, 2) }} kg</td>
            </tr>
            <tr>
                <td><strong>Usia Terkecil:</strong></td>
                <td>{{ $minUsia }} bulan</td>
            </tr>
            <tr>
                <td><strong>Usia Terbesar:</strong></td>
                <td>{{ $maxUsia }} bulan</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Tanggal Lahir</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Usia (bulan)</th>
                <th>Berat Badan</th>
                <th>Imunisasi</th>
                <th>Vitamin</th>
                <th>Nama Bidan</th>
                <th>Saran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->anak->nama_lengkap }}</td>
                <td>{{ \Carbon\Carbon::parse($p->anak->tgl_lahir)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                <td>{{ $p->usia_balita }}</td>
                <td>{{ $p->berat_badan }}</td>
                <td>{{ $p->imunisasi->jenis_imunisasi }}</td>
                <td>{{ $p->vitamin->jenis_vitamin }}</td>
                <td>{{ $p->bidan->nama_lengkap }}</td>
                <td>{{ $p->saran ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>