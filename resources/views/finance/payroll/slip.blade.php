<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            margin-bottom: 5px;
        }

        h2 {
            margin: 0;
        }

        .info-table td {
            padding: 4px 6px;
        }

        .section-title {
            margin-top: 20px;
            font-weight: bold;
            background: #f3f4f6;
            padding: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .border td {
            border: 1px solid #000;
            padding: 6px;
        }

        .right {
            text-align: right;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd td {
            text-align: center;
            padding-top: 40px;
        }

        .small {
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="header">

    {{-- LOGO --}}
    <img src="{{ public_path('logo.png') }}" class="logo">

    <h2>SLIP GAJI KARYAWAN</h2>

    <p class="small">
        Nomor Slip:
        SLIP/{{ $payroll->tahun }}/{{ str_pad($payroll->bulan,2,'0',STR_PAD_LEFT) }}/{{ $payroll->id }}
    </p>

    <p>
        Periode:
        {{ $payroll->bulan }}/{{ $payroll->tahun }}
    </p>
</div>

{{-- DATA KARYAWAN --}}
<table class="info-table">
    <tr>
        <td width="150">Nama</td>
        <td>: {{ $payroll->employee->nama_lengkap }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>: {{ $payroll->employee->nik }}</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>: {{ $payroll->employee->jabatan }}</td>
    </tr>
</table>


{{-- REKAP KEHADIRAN --}}
<div class="section-title">Rekap Kehadiran Bulan Ini</div>

<table class="border">
    <tr>
        <td>Total Hari Kerja</td>
        <td class="right">{{ $payroll->total_hari ?? '-' }} Hari</td>
    </tr>
    <tr>
        <td>Hadir</td>
        <td class="right">{{ $payroll->hari_hadir }} Hari</td>
    </tr>
    <tr>
        <td>Cuti</td>
        <td class="right">{{ $payroll->jumlah_cuti ?? 0 }} Hari</td>
    </tr>
    <tr>
        <td>Sakit</td>
        <td class="right">{{ $payroll->jumlah_sakit ?? 0 }} Hari</td>
    </tr>
    <tr>
        <td>Alpha</td>
        <td class="right">{{ $payroll->jumlah_alpha ?? 0 }} Hari</td>
    </tr>
</table>


{{-- PERHITUNGAN GAJI --}}
<div class="section-title">Perhitungan Gaji</div>

<table class="border">
    <tr>
        <td>Gaji Pokok</td>
        <td class="right">
            Rp {{ number_format($payroll->gaji_pokok,0,',','.') }}
        </td>
    </tr>
    <tr>
        <td>Potongan (Alpha)</td>
        <td class="right">
            Rp {{ number_format($payroll->potongan,0,',','.') }}
        </td>
    </tr>
    <tr>
        <td><strong>Gaji Bersih</strong></td>
        <td class="right">
            <strong>
                Rp {{ number_format($payroll->gaji_bersih,0,',','.') }}
            </strong>
        </td>
    </tr>
</table>


{{-- TTD --}}
<table class="ttd">
    <tr>
        <td>
            HRD<br><br><br>
            ___________________
        </td>
        <td>
            Karyawan<br><br><br>
            {{ $payroll->employee->nama_lengkap }}
        </td>
    </tr>
</table>

<p class="small">
    Dicetak pada: {{ now()->format('d-m-Y H:i') }}
</p>

</body>
</html>
