<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Pemeriksaan Ibu Hamil</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12pt;
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background-color: #f5f5f5;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Kartu Pemeriksaan Ibu Hamil</h2>
    <p><strong>Nama Ibu:</strong> {{ $pemeriksaan->ibu->nama_lengkap }}</p>
    <p><strong>Nama Bidan:</strong> {{ $pemeriksaan->bidan->nama_lengkap }}</p>

    <table>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <td>{{ \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <th>Keluhan</th>
            <td>{{ $pemeriksaan->keluhan }}</td>
        </tr>
        <tr>
            <th>Berat Badan</th>
            <td>{{ $pemeriksaan->berat_badan }} kg</td>
        </tr>
        <tr>
            <th>Tinggi Badan</th>
            <td>{{ $pemeriksaan->tinggi_badan }} cm</td>
        </tr>
        <tr>
            <th>Tekanan Darah</th>
            <td>{{ $pemeriksaan->tekanan_darah }}</td>
        </tr>
        <tr>
            <th>Usia Kehamilan</th>
            <td>{{ $pemeriksaan->usia_kehamilan }} minggu</td>
        </tr>
        <tr>
            <th>Tinggi Fundus</th>
            <td>{{ $pemeriksaan->tinggi_fundus }} cm</td>
        </tr>
        <tr>
            <th>Letak Janin</th>
            <td>{{ $pemeriksaan->letak_janin }}</td>
        </tr>
        <tr>
            <th>Denyut Jantung Janin</th>
            <td>{{ $pemeriksaan->denyut_jantung_janin }} bpm</td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $pemeriksaan->keterangan ?? '-' }}</td>
        </tr>
    </table>
</body>

</html>