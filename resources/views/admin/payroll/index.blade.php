@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold">Approval Payroll</h1>
        <p class="text-gray-500 text-sm">Review & approve payroll</p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-4">Nama</th>
                    <th>Bulan</th>
                    <th>Gaji Bersih</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($payrolls as $p)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-4">{{ $p->employee->nama_lengkap ?? '-' }}</td>
                    <td>{{ $p->bulan }}/{{ $p->tahun }}</td>
                    <td class="font-semibold">
                        Rp {{ number_format($p->gaji_bersih,0,',','.') }}
                    </td>

                    <td>
                        <span class="px-3 py-1 rounded-full text-xs
                            @if($p->status_approval == 'pending') bg-yellow-100 text-yellow-600
                            @elseif($p->status_approval == 'disetujui') bg-green-100 text-green-600
                            @else bg-red-100 text-red-600 @endif">
                            {{ ucfirst($p->status_approval) }}
                        </span>
                    </td>

                    <td class="text-center space-x-2">

                    {{-- Jika payroll sudah dikunci --}}
                @if($p->locked)

                    <span class="text-gray-400 text-xs font-semibold">
                     🔒 Terkunci
                    </span>

                     {{-- Jika belum dikunci dan masih pending --}}
                @elseif($p->status_approval == 'pending')

                        <form method="POST"
                            action="{{ route('admin.payroll.approve',$p->id) }}"
                                class="inline">
                @csrf
                        <button class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                            Approve
                        </button>
                    </form>

                    <form method="POST"
                        action="{{ route('admin.payroll.reject',$p->id) }}"
                            class="inline">
                 @csrf
                    <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">
                            Reject
                    </button>
                    </form>

                {{-- Jika sudah approve/reject tapi belum locked --}}
            @else
                    <span class="text-gray-400 text-xs">
                            Selesai
                     </span>

            @endif

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection
