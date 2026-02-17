@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('breadcrumb')
    <a href="{{ route('hrd.dashboard') }}" class="hover:text-blue-600">HRD</a>
    <span class="mx-2">/</span>
    <a href="{{ route('hrd.employees.index') }}" class="hover:text-blue-600">Data Karyawan</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Tambah</span>
@endsection

@section('content')

<div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-8">

    <h2 class="text-2xl font-semibold mb-6 text-gray-800">
        Form Tambah Karyawan
    </h2>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('hrd.employees.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- KODE KARYAWAN --}}
            <div>
                <label class="text-sm text-gray-600">Kode Karyawan</label>
                <input type="text" name="employee_code" required
                       value="{{ old('employee_code') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="text-sm text-gray-600">Email Login</label>
                <input type="email" name="email" required
                       value="{{ old('email') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- NAMA --}}
            <div>
                <label class="text-sm text-gray-600">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required
                       value="{{ old('nama_lengkap') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- NIK --}}
            <div>
                <label class="text-sm text-gray-600">NIK</label>
                <input type="text" name="nik" required
                       value="{{ old('nik') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- JABATAN --}}
            <div>
                <label class="text-sm text-gray-600">Jabatan</label>
                <input type="text" name="jabatan" required
                       value="{{ old('jabatan') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- TANGGAL MASUK --}}
            <div>
                <label class="text-sm text-gray-600">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" required
                       value="{{ old('tanggal_masuk') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- JENIS KELAMIN --}}
            <div>
                <label class="text-sm text-gray-600">Jenis Kelamin</label>
                <select name="jenis_kelamin" required
                        class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- TEMPAT LAHIR --}}
            <div>
                <label class="text-sm text-gray-600">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" required
                       value="{{ old('tempat_lahir') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- TANGGAL LAHIR --}}
            <div>
                <label class="text-sm text-gray-600">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" required
                       value="{{ old('tanggal_lahir') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- NO HP --}}
            <div>
                <label class="text-sm text-gray-600">No HP</label>
                <input type="text" name="no_hp" required
                       value="{{ old('no_hp') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- PENDIDIKAN --}}
            <div>
                <label class="text-sm text-gray-600">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir" required
                       value="{{ old('pendidikan_terakhir') }}"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- ALAMAT --}}
            <div class="md:col-span-2">
                <label class="text-sm text-gray-600">Alamat</label>
                <textarea name="alamat" rows="3" required
                          class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">{{ old('alamat') }}</textarea>
            </div>

        </div>

        <div class="flex justify-end mt-8 gap-3">
            <a href="{{ route('hrd.employees.index') }}"
               class="px-5 py-2 border rounded-lg hover:bg-gray-100 transition">
                Batal
            </a>

            <button
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
                Simpan Karyawan
            </button>
        </div>

    </form>
</div>

@endsection
