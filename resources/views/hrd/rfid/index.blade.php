@extends('layouts.app')

@section('title', 'Registrasi RFID')

@section('breadcrumb')
    <a href="{{ route('hrd.dashboard') }}" class="hover:text-blue-600">HRD</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">RFID</span>
@endsection

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Daftar Kartu RFID</h2>

    <a href="{{ route('hrd.rfid.create') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        + Registrasi RFID
    </a>
</div>

@if(session('success'))
    <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-3 text-left">Nama Karyawan</th>
                <th class="p-3 text-center">UID RFID</th>
                <th class="p-3 text-center">Status</th>
                <th class="p-3 text-center">Tanggal Daftar</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($cards as $r)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="p-3">
                    {{ $r->employee->nama_lengkap ?? '-' }}
                </td>

                <td class="p-3 text-center font-mono">
                    {{ $r->uid_rfid }}
                </td>

                <td class="p-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs
                        {{ $r->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $r->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>

                <td class="p-3 text-center">
                    {{ optional($r->registered_at)->format('d-m-Y') }}
                </td>

                <td class="p-3 text-center">
                    <form action="{{ route('hrd.rfid.destroy', $r->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus kartu RFID ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-600 hover:text-red-800 text-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-gray-500">
                    Belum ada data kartu RFID
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
