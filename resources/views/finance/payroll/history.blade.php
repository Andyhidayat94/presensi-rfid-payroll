@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold">Riwayat Payroll Bulanan</h1>
        <p class="text-gray-500 text-sm">
            Histori pembayaran gaji seluruh bulan
        </p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">Periode</th>
                    <th class="p-4 text-left">Jumlah Karyawan</th>
                    <th class="p-4 text-left">Total Potongan</th>
                    <th class="p-4 text-left">Total Gaji Dibayar</th>
                    <th class="p-4 text-center">Detail</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $row)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4 font-semibold">
                        {{ $row->bulan }}/{{ $row->tahun }}
                    </td>

                    <td class="p-4">
                        {{ $row->total_karyawan }}
                    </td>

                    <td class="p-4 text-red-600">
                        Rp {{ number_format($row->total_potongan,0,',','.') }}
                    </td>

                    <td class="p-4 font-bold text-green-600">
                        Rp {{ number_format($row->total_gaji,0,',','.') }}
                    </td>

                    <td class="p-4 text-center">
                        <a href="{{ route('finance.dashboard', ['bulan'=>$row->bulan,'tahun'=>$row->tahun]) }}"
                           class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            Lihat
                        </a>
                    </td>
                </tr>
                @endforeach

                @if($data->isEmpty())
                <tr>
                    <td colspan="5" class="text-center p-6 text-gray-500">
                        Belum ada data payroll
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

@endsection
