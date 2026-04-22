@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Approval Setting Gaji</h1>

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

            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Jabatan</th>
                    <th>Divisi</th>
                    <th>Tipe</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($rules as $r)
                <tr class="border-t">

                    <td class="p-3">{{ $r->position->name }}</td>

                    <td>{{ $r->department->name ?? '-' }}</td>

                    <td>
                        {{ ucfirst($r->tipe_gaji) }}
                    </td>

                    <td>
                        @if($r->tipe_gaji == 'harian')
                            Rp {{ number_format($r->upah_harian,0,',','.') }}
                        @else
                            Rp {{ number_format($r->gaji_pokok,0,',','.') }}
                        @endif
                    </td>

                    <td>
                        @if($r->status == 'pending')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded">Pending</span>
                        @elseif($r->status == 'approved')
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded">Approved</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-600 rounded">Rejected</span>
                        @endif
                    </td>

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
                @endforeach
            </tbody>

        </table>

    </div>

</div>
@endsection