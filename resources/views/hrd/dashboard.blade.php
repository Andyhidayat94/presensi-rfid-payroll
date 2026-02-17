@extends('layouts.app')

@section('title', 'Dashboard HRD')

@section('breadcrumb')
    <span class="text-gray-400">Home</span>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">HRD</span>
@endsection

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- TOTAL KARYAWAN --}}
    <div class="bg-white rounded-xl shadow p-6
                transition hover:shadow-lg hover:-translate-y-1
                border-l-4 border-blue-500">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full
                        flex items-center justify-center text-xl">
                👥
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Karyawan</p>
                <p class="text-3xl font-bold">{{ $totalEmployees }}</p>
            </div>
        </div>
    </div>

    {{-- MENUNGGU APPROVAL --}}
    <div class="bg-white rounded-xl shadow p-6
                transition hover:shadow-lg hover:-translate-y-1
                border-l-4 border-yellow-500">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full
                        flex items-center justify-center text-xl">
                ⏳
            </div>
            <div>
                <p class="text-sm text-gray-500">Menunggu Approval</p>
                <p class="text-3xl font-bold">{{ $pendingEmployees }}</p>
            </div>
        </div>
    </div>

    {{-- RFID AKTIF --}}
    <div class="bg-white rounded-xl shadow p-6
                transition hover:shadow-lg hover:-translate-y-1
                border-l-4 border-green-500">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full
                        flex items-center justify-center text-xl">
                💳
            </div>
            <div>
                <p class="text-sm text-gray-500">RFID Aktif</p>
                <p class="text-3xl font-bold">{{ $activeRfid }}</p>
            </div>
        </div>
    </div>

</div>

@endsection
