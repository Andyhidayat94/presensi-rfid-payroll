@extends('layouts.app')

@section('title', 'Rekap Presensi Harian')

@section('breadcrumb')
    <a href="{{ route('hrd.dashboard') }}" class="hover:text-blue-600">HRD</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Rekap Presensi Harian</span>
@endsection

@section('content')

{{-- FILTER TANGGAL --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form method="GET" class="flex gap-4 items-end">
        <div>
            <label class="text-sm text-gray-600">Tanggal</label>
            <input type="date"
                   name="tanggal"
                   value="{{ $tanggal }}"
                   class="border rounded-lg px-3 py-2">
        </div>

        <button
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Tampilkan
        </button>

        <a href="{{ route('hrd.attendance.export.pdf', ['tanggal' => $tanggal]) }}"
           class="ml-auto px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Export PDF
        </a>
    </form>
</div>

{{-- TABEL PRESENSI --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-3">Nama</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Masuk</th>
                <th class="p-3">Pulang</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $a)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="p-3">{{ $a->employee->nama_lengkap ?? '-' }}</td>
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
            @empty
            <tr>
                <td colspan="5" class="p-4 text-center text-gray-500">
                    Tidak ada data presensi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
