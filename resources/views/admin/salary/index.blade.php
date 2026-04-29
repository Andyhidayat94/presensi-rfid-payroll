@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Approval Setting Gaji</h1>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm">

            {{-- HEADER --}}
            <thead class="bg-gray-50">
                <tr class="text-left">
                    <th class="p-3">Jabatan</th>
                    <th>Divisi</th>
                    <th>Tipe</th>
                    <th>Gaji Pokok</th>
                    <th>Uang Harian</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody>
                @forelse($rules as $r)
                <tr class="border-t">

                    {{-- JABATAN --}}
                    <td class="p-3 font-medium">
                        {{ $r->position->name }}
                    </td>

                    {{-- DIVISI --}}
                    <td>
                        {{ $r->department->name ?? '-' }}
                    </td>

                    {{-- TIPE --}}
                    <td>
                        @if($r->tipe_gaji == 'harian')
                            <span class="text-blue-600 text-xs">
                                Operator (Harian)
                            </span>
                        @else
                            <span class="text-green-600 text-xs">
                                Bulanan + Harian
                            </span>
                        @endif
                    </td>

                    {{-- GAJI POKOK --}}
                    <td>
                        @if($r->gaji_pokok > 0)
                            Rp {{ number_format($r->gaji_pokok,0,',','.') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>

                    {{-- UANG HARIAN --}}
                    <td class="text-blue-600 font-semibold">
                        Rp {{ number_format($r->uang_harian,0,',','.') }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($r->status == 'pending')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">
                                Pending
                            </span>
                        @elseif($r->status == 'approved')
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                Approved
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                Rejected
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td>
                        @if($r->status == 'pending')
                            <div class="flex gap-2">

                                <form action="{{ route('admin.salary.settings.approve', $r->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.salary.settings.reject', $r->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">
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
                    <td colspan="7" class="text-center p-5 text-gray-400">
                        Tidak ada data yang perlu di-approve
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>
@endsection