@extends('layouts.app')

@section('breadcrumb')
    <span class="text-blue-600 font-semibold">
        Dashboard Finance
    </span>
@endsection

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Dashboard Finance
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Ringkasan payroll bulan {{ $bulan }} / {{ $tahun }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-600">
            <p class="text-sm text-slate-500">Total Karyawan Digaji</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">
                {{ $totalKaryawan }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-600">
            <p class="text-sm text-slate-500">Total Gaji Dibayarkan</p>
            <p class="text-3xl font-bold text-green-600 mt-2">
                Rp {{ number_format($totalGaji,0,',','.') }}
            </p>
        </div>

    </div>

</div>

@endsection
