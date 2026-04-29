<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .box { border:1px solid #000; padding:20px; }
        .title { text-align:center; font-size:18px; font-weight:bold; }
        .section { margin-top:15px; }
        table { width:100%; border-collapse: collapse; }
        td { padding:5px; }
        .border-top { border-top:1px solid #000; }
    </style>
</head>
<body>

<div class="box">

    <div class="title">SLIP GAJI KARYAWAN</div>

    <div class="section">
        <table>
            <tr>
                <td>Nama</td>
                <td>: {{ $payroll->employee->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>: {{ $payroll->bulan }}/{{ $payroll->tahun }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
       <strong>Rincian Kehadiran</strong>
<table>
    <tr>
        <td>Hari Kerja</td>
        <td>: {{ $hariKerja }}</td>
    </tr>
    <tr>
        <td>Hadir</td>
        <td>: {{ $hadir }}</td>
    </tr>
    <tr>
        <td>Cuti</td>
        <td>: {{ $cuti }}</td>
    </tr>
    <tr>
        <td>Sakit</td>
        <td>: {{ $sakit }}</td>
    </tr>
    <tr>
        <td>Alpha</td>
        <td>: {{ $alpha }}</td>
    </tr>
</table>
</div>

<div class="section">
    <strong>Perhitungan Gaji</strong>
    <table>
        <tr>
            <td>Total Dibayar</td>
            <td>: {{ $totalDibayar }} hari</td>
        </tr>

        @if($payroll->tipe_gaji == 'harian')
        <tr>
            <td>Upah Harian</td>
            <td>: Rp {{ number_format($payroll->upah_harian,0,',','.') }}</td>
        </tr>
        @else
        <tr>
            <td>Gaji Pokok</td>
            <td>: Rp {{ number_format($payroll->gaji_pokok,0,',','.') }}</td>
        </tr>
        @endif

        <tr class="border-top">
            <td><strong>Gaji Bersih</strong></td>
            <td>
                <strong>
                    Rp {{ number_format($payroll->gaji_bersih,0,',','.') }}
                </strong>
            </td>
        </tr>
    </table>
</div>

</body>
</html>