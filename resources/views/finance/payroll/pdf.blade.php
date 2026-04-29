<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>

<h2>DATA PAYROLL</h2>
<p>Bulan: {{ $bulan }} / {{ $tahun }}</p>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Tipe</th>
            <th>Hadir</th>
            <th>Cuti</th>
            <th>Sakit</th>
            <th>Alpha</th>
            <th>Gaji Pokok</th>
            <th>Uang Harian</th>
            <th>Gaji Bersih</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payrolls as $p)
        <tr>
            <td>{{ $p->employee->nama_lengkap }}</td>
            <td>{{ $p->tipe_gaji }}</td>
            <td>{{ $p->hari_hadir }}</td>
            <td>{{ $p->total_cuti }}</td>
            <td>{{ $p->total_sakit }}</td>
            <td>{{ $p->total_alpha }}</td>
            <td>{{ number_format($p->gaji_pokok,0,',','.') }}</td>
            <td>{{ number_format($p->upah_harian,0,',','.') }}</td>
            <td><strong>{{ number_format($p->gaji_bersih,0,',','.') }}</strong></td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>