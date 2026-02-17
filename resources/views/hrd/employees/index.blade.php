@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('breadcrumb')
    <a href="/hrd/dashboard" class="hover:text-blue-600">HRD</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Data Karyawan</span>
@endsection

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Data Karyawan</h2>

    <a href="{{ route('hrd.employees.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        + Tambah Karyawan
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3">NIK</th>
                <th class="p-3">Jabatan</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $e)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="p-3">{{ $e->nama_lengkap }}</td>
                <td class="p-3 text-center">{{ $e->nik }}</td>
                <td class="p-3 text-center">{{ $e->jabatan }}</td>
                <td class="p-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs
                        {{ $e->status_kerja === 'aktif'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($e->status_kerja) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
