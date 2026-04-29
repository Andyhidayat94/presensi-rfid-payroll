@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Setting Gaji</h1>

        <a href="{{ route('finance.salary.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah Gaji
        </a>

    <form action="{{ route('finance.payroll.export') }}" method="GET" class="mb-4">
    <input type="hidden" name="bulan" value="{{ request('bulan') }}">
    <input type="hidden" name="tahun" value="{{ request('tahun') }}">

    <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Export PDF
    </button>
</form>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm">

            {{-- HEAD --}}
            <thead class="bg-gray-50 text-gray-600">
                <tr class="text-left">
                    <th class="p-4">Jabatan</th>
                    <th>Divisi</th>
                    <th>Tipe</th>
                    <th>Gaji Pokok</th>
                    <th>Uang Harian</th>
                    <th>Status</th>
                    <th>Approved</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody>
                @forelse($rules as $r)
                <tr class="border-t hover:bg-gray-50 transition">

                    {{-- JABATAN --}}
                    <td class="p-4 font-medium">
                        {{ $r->position->name }}
                    </td>

                    {{-- DIVISI --}}
                    <td>
                        {{ $r->department->name ?? '-' }}
                    </td>

                    {{-- TIPE --}}
                    <td>
                        @if($r->tipe_gaji == 'harian')
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded">
                                Operator (Harian)
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded">
                                Bulanan + Harian
                            </span>
                        @endif
                    </td>

                    {{-- GAJI POKOK --}}
                    <td class="font-semibold">
                        @if($r->gaji_pokok > 0)
                            Rp {{ number_format($r->gaji_pokok,0,',','.') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>

                    {{-- UANG HARIAN --}}
                    <td class="font-semibold text-blue-600">
                        Rp {{ number_format($r->uang_harian,0,',','.') }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($r->status == 'pending')
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                Pending
                            </span>
                        @elseif($r->status == 'approved')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                Approved
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                Rejected
                            </span>
                        @endif
                    </td>

                    {{-- APPROVED AT --}}
                    <td class="text-gray-500 text-xs">
                        @if($r->approved_at)
                            {{ \Carbon\Carbon::parse($r->approved_at)->format('d M Y H:i') }}
                        @else
                            -
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td>
                        @if($r->status == 'pending' && auth()->user()->role == 'admin')
                            <div class="flex gap-2">

                                <form action="{{ route('finance.salary.approve', $r->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 text-xs bg-green-600 text-white rounded">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('finance.salary.reject', $r->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 text-xs bg-red-600 text-white rounded">
                                        Reject
                                    </button>
                                </form>

                            </div>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center p-6 text-gray-400">
                        Belum ada data setting gaji
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>
@endsection