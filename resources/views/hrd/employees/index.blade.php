@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')

<div class="flex justify-between mb-4">
    <h2 class="text-xl font-bold">Data Karyawan</h2>

    <a href="{{ route('hrd.employees.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        + Tambah
    </a>
</div>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 text-left">Nama</th>
            <th>NIK</th>
            <th>Jabatan</th>
            <th>Divisi</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse($employees as $e)
        <tr class="border-t">
            <td class="p-3">{{ $e->nama_lengkap }}</td>
            <td>{{ $e->nik }}</td>

            {{-- POSITION --}}
            <td>
                {{ $e->position->name ?? '-' }}
            </td>

            {{-- DEPARTMENT --}}
            <td>
                {{ $e->department->name ?? '-' }}
            </td>

            <td>
                @if($e->status_kerja == 'aktif')
                    <span class="text-green-600">Aktif</span>
                @else
                    <span class="text-yellow-600">Pending</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center p-4 text-gray-500">
                Belum ada karyawan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection