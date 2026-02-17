@extends('layouts.app')

@section('breadcrumb')
    <a href="{{ route('finance.dashboard') }}" class="hover:text-blue-600">
        Dashboard
    </a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-semibold">
        Payroll
    </span>
@endsection

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">
            Data Payroll
        </h1>

        <form action="{{ route('finance.payroll.generate') }}" method="POST" class="flex gap-2">
            @csrf
            <select name="bulan" class="border rounded px-3 py-2 text-sm">
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>

            <input type="number"
                   name="tahun"
                   value="{{ date('Y') }}"
                   class="border rounded px-3 py-2 text-sm w-24">

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                Generate
            </button>
        </form>
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
                        <th class="p-4 text-left">Periode</th>
                        <th class="p-4 text-right">Gaji Bersih</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                @forelse($payrolls as $payroll)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-medium">
                            {{ $payroll->employee->nama_lengkap }}
                        </td>

                        <td class="p-4">
                            {{ $payroll->bulan }} / {{ $payroll->tahun }}
                        </td>

                        <td class="p-4 text-right font-semibold text-green-600">
                            Rp {{ number_format($payroll->gaji_bersih,0,',','.') }}
                        </td>

                        <td class="p-4 text-center">
                            <a href="{{ route('finance.payroll.download', $payroll->id) }}"
                               class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs">
                                Download Slip
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center text-slate-400">
                            Belum ada data payroll
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
