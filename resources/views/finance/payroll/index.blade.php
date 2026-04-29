@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Payroll Bulanan</h1>

    {{-- FORM GENERATE --}}
    <form action="{{ route('finance.payroll.generate') }}" method="POST" class="mb-3 flex gap-3">
        @csrf

        <input type="number" name="bulan" placeholder="Bulan"
            class="border px-3 py-2 rounded w-32" required>

        <input type="number" name="tahun" placeholder="Tahun"
            class="border px-3 py-2 rounded w-32" required>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Generate
        </button>
    </form>

    {{-- FORM EXPORT --}}
    <form action="{{ route('finance.payroll.export.excel') }}" method="GET" class="mb-6 flex gap-3">

        <input type="number" name="bulan" placeholder="Bulan"
            class="border px-3 py-2 rounded w-32" required>

        <input type="number" name="tahun" placeholder="Tahun"
            class="border px-3 py-2 rounded w-32" required>

        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Export Excel
        </button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="p-3">Nama</th>
                    <th>Periode</th>
                    <th>Tipe</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Cuti</th>
                    <th class="text-center">Sakit</th>
                    <th class="text-center">Alpha</th>
                    <th class="text-right">Gaji Pokok</th>
                    <th class="text-right">Uang Harian</th>
                    <th class="text-right">Total Gaji</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payrolls as $p)
                <tr class="border-t hover:bg-gray-50 transition">

                    {{-- NAMA --}}
                    <td class="p-3 font-medium">
                        {{ $p->employee->nama_lengkap }}
                    </td>

                    {{-- PERIODE --}}
                    <td>
                        {{ $p->bulan }}/{{ $p->tahun }}
                    </td>

                    {{-- TIPE --}}
                    <td>
                        @if($p->tipe_gaji == 'harian')
                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded">
                                Operator
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded">
                                Bulanan + Harian
                            </span>
                        @endif
                    </td>

                    {{-- HADIR --}}
                    <td class="text-center">{{ $p->hari_hadir }}</td>

                    {{-- CUTI --}}
                    <td class="text-center">{{ $p->total_cuti ?? 0 }}</td>

                    {{-- SAKIT --}}
                    <td class="text-center">{{ $p->total_sakit ?? 0 }}</td>

                    {{-- ALPHA --}}
                    <td class="text-center text-red-500 font-semibold">
                        {{ $p->total_alpha }}
                    </td>

                    {{-- GAJI POKOK --}}
                    <td class="text-right">
                        @if($p->gaji_pokok > 0)
                            Rp {{ number_format($p->gaji_pokok,0,',','.') }}
                        @else
                            -
                        @endif
                    </td>

                    {{-- UANG HARIAN --}}
                    <td class="text-right">
                        Rp {{ number_format($p->upah_harian,0,',','.') }}
                    </td>

                    {{-- TOTAL --}}
                    <td class="text-right font-bold text-green-600">
                        Rp {{ number_format($p->gaji_bersih,0,',','.') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="text-center">
                        @if($p->status_approval == 'pending')
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                Pending
                            </span>
                        @elseif($p->status_approval == 'approved')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                Approved
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                Rejected
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="text-center">

                        @if(in_array($p->status_approval, ['pending','rejected']))
                            <form action="{{ route('finance.payroll.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus payroll ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center p-6 text-gray-400">
                        Belum ada data payroll
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>
@endsection