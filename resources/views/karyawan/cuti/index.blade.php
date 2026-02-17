@extends('layouts.app')

@section('breadcrumb')
    <a href="/karyawan/dashboard" class="hover:text-blue-600">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Pengajuan Cuti</span>
@endsection

@section('content')

<div class="bg-white rounded-xl shadow-sm p-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
            📝 Riwayat Pengajuan
            </h2>
        </div>

        <a href="{{ route('karyawan.cuti.create') }}"
           class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg shadow transition">
            + Ajukan Cuti
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-100 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-200">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-4 text-left">Jenis</th>
                        <th class="p-4 text-left">Periode</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($requests as $r)
                    <tr class="hover:bg-slate-50 transition">

                        {{-- JENIS --}}
                        <td class="p-4 capitalize font-medium text-slate-700">
                            {{ $r->jenis_izin }}
                        </td>

                        {{-- PERIODE --}}
                        <td class="p-4 text-slate-600">
                            {{ \Carbon\Carbon::parse($r->tanggal_mulai)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($r->tanggal_selesai)->format('d M Y') }}
                        </td>

                        {{-- STATUS --}}
                        <td class="p-4 text-center">
                            @if($r->status == 'approved')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Disetujui
                                </span>
                            @elseif($r->status == 'rejected')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    Ditolak
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    Menunggu
                                </span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-10 text-center text-slate-400">
                            Belum ada pengajuan cuti
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
