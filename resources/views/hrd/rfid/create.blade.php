@extends('layouts.app')

@section('title', 'Registrasi RFID')

@section('breadcrumb')
    <a href="{{ route('hrd.rfid.index') }}" class="hover:text-blue-600">RFID</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Tambah</span>
@endsection

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-semibold mb-6">Form Registrasi RFID</h2>

    <form method="POST" action="{{ route('hrd.rfid.store') }}">
        @csrf

        {{-- PILIH KARYAWAN --}}
        <div class="mb-4">
            <label class="text-sm text-gray-600">Karyawan</label>
            <select name="employee_id" required
                    class="w-full mt-1 border rounded-lg px-3 py-2">
                <option value="">-- Pilih Karyawan --</option>
                @foreach($employees as $e)
                    <option value="{{ $e->id }}">{{ $e->nama_lengkap }} - {{ $e->jabatan }}</option>
                @endforeach
            </select>
        </div>

        {{-- UID RFID --}}
        <div class="mb-4">
            <label class="text-sm text-gray-600">UID RFID</label>
            <input type="text" name="uid_rfid" required
                   class="w-full mt-1 border rounded-lg px-3 py-2"
                   placeholder="Tempel kartu RFID">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('hrd.rfid.index') }}"
               class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Batal
            </a>

            <button
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Simpan
            </button>
        </div>

    </form>
</div>

@endsection
