@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Dashboard Finance</h1>
            <p class="text-gray-500 text-sm">
                Monitoring Payroll Bulanan (Realtime)
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

    {{-- SUMMARY --}}
    <div class="grid grid-cols-3 gap-6 mb-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Gaji Dibayar</p>
            <p class="text-xl font-bold text-green-600">
                Rp {{ number_format($totalGaji,0,',','.') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Jumlah Karyawan</p>
            <p class="text-xl font-bold">
                {{ $totalKaryawan }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-sm text-gray-500">Karyawan Bermasalah (Alpha > 3)</p>
            <p class="text-xl font-bold text-red-600">
                {{ $karyawanBermasalah ?? 0 }}
            </p>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="text-center">Tipe</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Cuti</th>
                    <th class="text-center">Sakit</th>
                    <th class="text-center">Alpha</th>
                    <th class="text-right">Gaji Pokok</th>
                    <th class="text-right">Uang Harian</th>
                    <th class="text-right">Total Gaji</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $row)
                <tr class="border-t hover:bg-gray-50">

                    {{-- NAMA --}}
                    <td class="p-3 font-medium">
                        {{ $row['nama'] }}
                    </td>

                    {{-- TIPE --}}
                    <td class="text-center">
                        @if($row['tipe'] == 'harian')
                            <span class="text-blue-600 text-xs">Operator</span>
                        @else
                            <span class="text-green-600 text-xs">Bulanan + Harian</span>
                        @endif
                    </td>

                    {{-- HADIR --}}
                    <td class="text-center">{{ $row['hadir'] }}</td>

                    {{-- CUTI --}}
                    <td class="text-center">{{ $row['cuti'] }}</td>

                    {{-- SAKIT --}}
                    <td class="text-center">{{ $row['sakit'] }}</td>

                    {{-- ALPHA --}}
                    <td class="text-center font-semibold 
                        {{ $row['alpha'] > 3 ? 'text-red-600' : 'text-gray-700' }}">
                        {{ $row['alpha'] }}
                    </td>

                    {{-- GAJI POKOK --}}
                    <td class="text-right">
                        @if($row['gaji_pokok'] > 0)
                            Rp {{ number_format($row['gaji_pokok'],0,',','.') }}
                        @else
                            -
                        @endif
                    </td>

                    {{-- UANG HARIAN --}}
                    <td class="text-right">
                        Rp {{ number_format($row['uang_harian'],0,',','.') }}
                    </td>

                    {{-- TOTAL --}}
                    <td class="text-right font-bold text-green-600">
                        Rp {{ number_format($row['gaji'],0,',','.') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="text-center">
                        @if($row['status'] == 'pending')
                            <span class="text-yellow-600 text-xs">Pending</span>
                        @elseif($row['status'] == 'approved')
                            <span class="text-green-600 text-xs">Approved</span>
                        @else
                            <span class="text-red-600 text-xs">Rejected</span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center p-6 text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection