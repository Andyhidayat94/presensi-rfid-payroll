@extends('layouts.app')

@section('title', 'Presensi Saya')

@section('breadcrumb')
    <a href="/karyawan/dashboard" class="hover:text-blue-600">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Presensi Saya</span>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">
        📅 Riwayat Presensi
    </h2>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border border-slate-200 rounded-lg overflow-hidden">
            <thead class="bg-slate-100 text-slate-700">
                <tr>
                    <th class="px-4 py-3 border">Tanggal</th>
                    <th class="px-4 py-3 border">Jam Masuk</th>
                    <th class="px-4 py-3 border">Jam Pulang</th>
                    <th class="px-4 py-3 border text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $a)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-2 border">{{ $a->tanggal }}</td>
                    <td class="px-4 py-2 border">{{ $a->jam_masuk ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $a->jam_pulang ?? '-' }}</td>
                    <td class="px-4 py-2 border text-center">
                        @php
                            $badge = [
                                'hadir' => 'bg-green-100 text-green-700',
                                'telat' => 'bg-yellow-100 text-yellow-700',
                                'izin'  => 'bg-blue-100 text-blue-700',
                                'alpha' => 'bg-red-100 text-red-700',
                            ];
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge[$a->status_hadir] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($a->status_hadir ?? '-') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-slate-500">
                        Belum ada data presensi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
