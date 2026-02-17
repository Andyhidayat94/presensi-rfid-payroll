@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Dashboard Finance</h1>
            <p class="text-gray-500 text-sm">
                Ringkasan Payroll Bulanan
            </p>
        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="flex gap-4 mb-6">
        <select name="bulan" class="border rounded px-3 py-2">
            @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>

        <select name="tahun" class="border rounded px-3 py-2">
            @for($y=2024;$y<=now()->year+1;$y++)
                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Tampilkan
        </button>
    </form>

    {{-- SUMMARY CARD --}}
    <div class="grid grid-cols-3 gap-6 mb-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Gaji Dibayar</p>
            <p class="text-xl font-bold">
                Rp {{ number_format($totalGaji,0,',','.') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Potongan</p>
            <p class="text-xl font-bold text-red-600">
                Rp {{ number_format($totalPotongan,0,',','.') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Jumlah Karyawan</p>
            <p class="text-xl font-bold">
                {{ $totalKaryawan }}
            </p>
        </div>

    </div>

    {{-- TABEL DETAIL --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Hari Hadir</th>
                    <th class="p-3 text-left">Alpha</th>
                    <th class="p-3 text-left">Cuti</th>
                    <th class="p-3 text-left">Sakit</th>
                    <th class="p-3 text-left">Gaji Bersih</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payrolls as $p)
                <tr class="border-t">
                    <td class="p-3">
                        {{ $p->employee->nama_lengkap ?? '-' }}
                    </td>
                    <td class="p-3">{{ $p->hari_hadir }}</td>
                    <td class="p-3 text-red-500">{{ $p->jumlah_alpha ?? 0 }}</td>
                    <td class="p-3">{{ $p->jumlah_cuti ?? 0 }}</td>
                    <td class="p-3">{{ $p->jumlah_sakit ?? 0 }}</td>
                    <td class="p-3 font-semibold">
                        Rp {{ number_format($p->gaji_bersih,0,',','.') }}
                    </td>
                </tr>
                @endforeach

                @if($payrolls->isEmpty())
                <tr>
                    <td colspan="6" class="text-center p-6 text-gray-500">
                        Tidak ada data payroll bulan ini
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

</div>

@endsection
