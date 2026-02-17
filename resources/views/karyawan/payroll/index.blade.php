@extends('layouts.app')

@section('title', 'Slip Gaji')

@section('breadcrumb')
    <a href="/karyawan/dashboard" class="hover:text-blue-600">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Slip Gaji</span>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">
        💰 Riwayat Slip Gaji
    </h2>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border border-slate-200 rounded-lg overflow-hidden">
            <thead class="bg-slate-100 text-slate-700">
                <tr>
                    <th class="px-4 py-3 border">Bulan</th>
                    <th class="px-4 py-3 border">Tahun</th>
                    <th class="px-4 py-3 border text-center">Hadir</th>
                    <th class="px-4 py-3 border">Gaji Bersih</th>
                    <th class="px-4 py-3 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $p)
                <tr class="hover:bg-slate-50">
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-2 border">{{ $p->bulan }}</td>
                    <td class="px-4 py-2 border">{{ $p->tahun }}</td>
                    <td class="px-4 py-2 border text-center">
                        <span class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700 font-semibold">
                            {{ $p->hari_hadir }} hari
                        </span>
                    </td>
                    <td class="px-4 py-2 border font-semibold">
                        Rp {{ number_format($p->gaji_bersih, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 border text-center">
                        <a href="{{ url('/karyawan/slip-gaji/'.$p->id.'/pdf') }}"
                           class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold rounded bg-red-600 text-white hover:bg-red-700">
                            📄 PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-slate-500">
                        Belum ada slip gaji
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
