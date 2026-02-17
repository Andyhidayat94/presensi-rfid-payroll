@extends('layouts.app')

@section('breadcrumb')
    <a href="{{ route('hrd.dashboard') }}" class="hover:text-blue-600">
        Dashboard
    </a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-semibold">
        Review Pengajuan Cuti
    </span>
@endsection

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Review Pengajuan Cuti & Sakit
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Kelola dan verifikasi pengajuan karyawan
        </p>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-100 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">Jenis</th>
                        <th class="p-4 text-left">Periode</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                @forelse($requests as $r)
                    <tr class="hover:bg-slate-50">

                        <td class="p-4 font-medium text-slate-700">
                            {{ $r->employee->nama_lengkap }}
                        </td>

                        <td class="p-4 capitalize">
                            {{ $r->jenis_izin }}
                        </td>

                        <td class="p-4 text-slate-600">
                            {{ \Carbon\Carbon::parse($r->tanggal_mulai)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($r->tanggal_selesai)->format('d M Y') }}
                        </td>

                        <td class="p-4 text-center">
                            @if($r->status == 'disetujui')
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                    Disetujui
                                </span>
                            @elseif($r->status == 'ditolak')
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                    Ditolak
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                    Menunggu
                                </span>
                            @endif
                        </td>

                        <td class="p-4 text-center space-x-2">

                            @if($r->status == 'pending')

                                <form action="{{ route('hrd.cuti.approve',$r->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded-lg">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('hrd.cuti.reject',$r->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded-lg">
                                        Reject
                                    </button>
                                </form>

                            @else
                                <span class="text-slate-400 text-xs">Selesai</span>
                            @endif

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-slate-400">
                            Tidak ada pengajuan
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
