<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll Bulanan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h3 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        .right { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>

<h3>
    LAPORAN PAYROLL BULAN {{ $month }} TAHUN {{ $year }}
</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Jabatan</th>
            <th>Hadir</th>
            <th>Gaji Pokok</th>
            <th>Potongan</th>
            <th>Gaji Bersih</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payrolls as $i => $row)
        <tr>
            <td class="center">{{ $i + 1 }}</td>
            <td>{{ $row->employee->nama_lengkap }}</td>
            <td class="center">{{ $row->employee->nik }}</td>
            <td>{{ $row->employee->jabatan }}</td>
            <td class="center">{{ $row->hari_hadir }}</td>
            <td class="right">
                Rp {{ number_format($row->gaji_pokok,0,',','.') }}
            </td>
            <td class="right">
                Rp {{ number_format($row->potongan,0,',','.') }}
            </td>
            <td class="right">
                Rp {{ number_format($row->gaji_bersih,0,',','.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>
<p>
    Dicetak pada: {{ now()->format('d-m-Y') }}
</p>

</body>
</html>
