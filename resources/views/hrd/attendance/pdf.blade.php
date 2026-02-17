<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Presensi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>

<h3>Rekap Presensi Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</h3>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Masuk</th>
            <th>Pulang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $a)
        <tr>
            <td>{{ $a->employee->nama_lengkap ?? '-' }}</td>
            <td>{{ $a->jam_masuk ?? '-' }}</td>
            <td>{{ $a->jam_pulang ?? '-' }}</td>
            <td>{{ ucfirst($a->status_hadir) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
