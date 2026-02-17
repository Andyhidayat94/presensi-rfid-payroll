@extends('layouts.app')

@section('content')

<div class="mb-6">
    <h1 class="text-xl font-bold">Approval Karyawan</h1>
</div>

<form method="GET" class="mb-4 flex gap-3">
    <input type="text" name="search" placeholder="Cari nama..."
           class="border rounded px-3 py-2 text-sm">

    <select name="status" class="border rounded px-3 py-2 text-sm">
        <option value="">Semua</option>
        <option value="pending">Pending</option>
        <option value="aktif">Aktif</option>
    </select>

    <button class="bg-gray-800 text-white px-4 py-2 rounded text-sm">
        Filter
    </button>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 text-left">Nama</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $emp)
        <tr class="border-t">
            <td class="p-3">{{ $emp->nama_lengkap }}</td>

            <td>
                <span class="badge 
                    {{ $emp->status_kerja == 'pending' ? 'badge-yellow' : 'badge-green' }}">
                    {{ $emp->status_kerja }}
                </span>
            </td>

            <td>
                @if($emp->status_kerja == 'pending')
                <form method="POST" action="{{ route('admin.employees.approve',$emp->id) }}">
                    @csrf
                    <button class="btn-approve">Approve</button>
                </form>
                @else
                    <span class="text-gray-400">Selesai</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection
