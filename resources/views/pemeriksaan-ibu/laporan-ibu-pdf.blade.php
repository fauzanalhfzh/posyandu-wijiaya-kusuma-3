<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemeriksaan Ibu</title>
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
    <h2>Laporan Pemeriksaan Ibu</h2>
    <h4>Posyandu Wijaya Kusuma 3</h4>
    <h4>Bulan: {{ \Carbon\Carbon::createFromFormat('m', $bulan)->format('F Y') }}</h4>

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
                <td><strong>Rata-rata Tinggi Badan:</strong></td>
                <td>{{ number_format($avgTinggi, 2) }} cm</td>
            </tr>
            <tr>
                <td><strong>Rata-rata Usia Kehamilan:</strong></td>
                <td>{{ number_format($avgUsiaKehamilan, 1) }} minggu</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Ibu</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Berat Badan (kg)</th>
                <th>Tinggi Badan (cm)</th>
                <th>Tekanan Darah</th>
                <th>Usia Kehamilan (minggu)</th>
                <th>Tinggi Fundus</th>
                <th>Letak Janin</th>
                <th>Denyut Jantung Janin</th>
                <th>Nama Bidan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->ibu->nama_lengkap }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                <td>{{ $p->berat_badan }}</td>
                <td>{{ $p->tinggi_badan }}</td>
                <td>{{ $p->tekanan_darah }}</td>
                <td>{{ $p->usia_kehamilan }}</td>
                <td>{{ $p->tinggi_fundus }}</td>
                <td>{{ $p->letak_janin }}</td>
                <td>{{ $p->denyut_jantung_janin }}</td>
                <td>{{ $p->bidan->nama_lengkap }}</td>
                <td>{{ $p->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>