@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Payroll</h1>

    {{-- FORM GENERATE --}}
    <form action="{{ route('finance.payroll.generate') }}" method="POST" class="mb-6 flex gap-3">
        @csrf

        <input type="number" name="bulan" placeholder="Bulan (1-12)"
            class="border px-3 py-2 rounded w-40" required>

        <input type="number" name="tahun" placeholder="Tahun"
            class="border px-3 py-2 rounded w-40" required>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Generate
        </button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">Nama</th>
                    <th>Bulan</th>
                    <th>Hadir</th>
                    <th>Alpha</th>
                    <th>Cuti</th>
                    <th>Gaji</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $p)
                <tr class="border-t">
                    <td class="p-3">{{ $p->employee->nama_lengkap }}</td>
                    <td>{{ $p->bulan }}/{{ $p->tahun }}</td>
                    <td>{{ $p->hari_hadir }}</td>
                    <td>{{ $p->total_alpha ?? 0 }}</td>
                    <td>{{ $p->total_cuti ?? 0 }}</td>
                    <td class="font-semibold text-green-600">
                        Rp {{ number_format($p->gaji_bersih,0,',','.') }}
                    </td>
                    <td>
                        @if($p->status_approval == 'pending')
                            <span class="text-yellow-600">Pending</span>
                        @elseif($p->status_approval == 'approved')
                            <span class="text-green-600">Approved</span>
                        @else
                            <span class="text-red-600">Rejected</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-4 text-gray-500">
                        Belum ada data payroll
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection