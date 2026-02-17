@extends('layouts.app')

@section('title', 'Rekap Presensi Bulanan')

@section('breadcrumb')
    <a href="{{ route('hrd.dashboard') }}" class="hover:text-blue-600">HRD</a>
    <span class="mx-2">/</span>
    <a href="{{ route('hrd.attendance.index') }}" class="hover:text-blue-600">Presensi</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Bulanan</span>
@endsection

@section('content')

{{-- FILTER BULAN --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form method="GET" class="flex gap-4 items-end">
        <div>
            <label class="text-sm text-gray-600">Bulan</label>
            <select name="bulan" class="border rounded-lg px-3 py-2">
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600">Tahun</label>
            <select name="tahun" class="border rounded-lg px-3 py-2">
                @for($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        <button
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Tampilkan
        </button>
    </form>
</div>

{{-- DATA PRESENSI --}}
@forelse($attendances as $employeeAttendances)

@php
    $employee = $employeeAttendances->first()->employee;
@endphp

<div class="bg-white rounded-xl shadow mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b bg-gray-50">
        <h3 class="font-semibold text-lg">{{ $employee->nama_lengkap }}</h3>
        <p class="text-sm text-gray-500">{{ $employee->jabatan }}</p>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Masuk</th>
                <th class="p-3">Pulang</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employeeAttendances as $a)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="p-3 text-center">{{ $a->tanggal->format('d-m-Y') }}</td>
                <td class="p-3 text-center">{{ $a->jam_masuk ?? '-' }}</td>
                <td class="p-3 text-center">{{ $a->jam_pulang ?? '-' }}</td>
                <td class="p-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs
                        {{ $a->status_hadir === 'pulang'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($a->status_hadir) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@empty
<div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">
    Tidak ada data presensi untuk bulan ini.
</div>
@endforelse

@endsection
