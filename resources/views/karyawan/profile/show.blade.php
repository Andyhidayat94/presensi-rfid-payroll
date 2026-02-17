@extends('layouts.app')

@section('title', 'Profil Saya')

@section('breadcrumb')
    <a href="/karyawan/dashboard" class="hover:text-blue-600">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Profil Saya</span>
@endsection

@section('content')

<div class="flex items-center gap-6">

    {{-- Avatar --}}
    <div class="relative">
        @if($user->avatar)
            <img src="{{ asset('storage/'.$user->avatar) }}"
                 class="w-24 h-24 rounded-full object-cover border">
        @else
            <div class="w-24 h-24 rounded-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>
        @endif
    </div>

    {{-- Upload --}}
    <form method="POST"
          action="{{ route('karyawan.profile.avatar') }}"
          enctype="multipart/form-data">
        @csrf

        <label class="block text-sm font-medium text-gray-600 mb-1">
            Ubah Foto Profil
        </label>

        <input type="file" name="avatar"
               class="block w-full text-sm">

        <button
            class="mt-1 px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
            Upload
        </button>
    </form>

</div>

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Kartu Profil --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-6">
        <div class="w-20 h-20 rounded-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>

        <div>
            <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500">{{ $employee->jabatan }}</p>
            <p class="text-sm text-gray-400">Karyawan</p>
        </div>
    </div>

    {{-- Data Pribadi --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Data Pribadi</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Email</p>
                <p class="font-medium">{{ $user->email }}</p>
            </div>

            <div>
                <p class="text-gray-500">NIK</p>
                <p class="font-medium">{{ $employee->nik }}</p>
            </div>

            <div>
                <p class="text-gray-500">Jenis Kelamin</p>
                <p class="font-medium">
                    {{ $employee->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal Lahir</p>
                <p class="font-medium">{{ $employee->tanggal_lahir }}</p>
            </div>

            <div>
                <p class="text-gray-500">No HP</p>
                <p class="font-medium">{{ $employee->no_hp }}</p>
            </div>

            <div>
                <p class="text-gray-500">Alamat</p>
                <p class="font-medium">{{ $employee->alamat }}</p>
            </div>
        </div>
    </div>

</div>
@endsection
