@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('breadcrumb')
    <span class="text-gray-400">Home</span>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Dashboard</span>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- PROFIL --}}
    <div class="bg-white rounded-xl shadow p-6
                transition hover:shadow-lg hover:-translate-y-1
                border-l-4 border-blue-500">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full
                        flex items-center justify-center text-xl font-bold">
                👤
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama</p>
                <p class="text-lg font-semibold">{{ $employee->nama_lengkap }}</p>
                <p class="text-sm text-gray-500">{{ $employee->jabatan }}</p>
            </div>
        </div>
    </div>

    {{-- KEHADIRAN --}}
    <div class="bg-white rounded-xl shadow p-6
                transition hover:shadow-lg hover:-translate-y-1
                border-l-4 border-green-500">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full
                        flex items-center justify-center text-xl">
                📅
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Kehadiran</p>
                <p class="text-3xl font-bold text-emerald-600">{{ $totalHadir }}</p>
                <p class="text-sm text-gray-500">Hari kerja</p>
            </div>
        </div>
    </div>

    {{-- GAJI --}}
    <div class="bg-white rounded-xl shadow p-6
                transition hover:shadow-lg hover:-translate-y-1
                border-l-4 border-indigo-600">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full
                        flex items-center justify-center text-xl">
                💰
            </div>
            <div>
                <p class="text-sm text-gray-500">Gaji Terakhir</p>
                @if($latestPayroll)
                    <p class="text-lg font-semibold">
                        Rp {{ number_format($latestPayroll->gaji_bersih,0,',','.') }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $latestPayroll->bulan }}/{{ $latestPayroll->tahun }}
                    </p>
                @else
                    <p class="text-sm text-gray-500">Belum tersedia</p>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
