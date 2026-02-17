@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Profil Akun
        </h1>
        <p class="text-sm text-gray-500">
            Dashboard / Profil
        </p>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- PROFILE CARD --}}
    <div class="grid md:grid-cols-3 gap-6">

        {{-- LEFT PANEL --}}
        <div class="bg-white rounded-xl shadow p-6 text-center">

            {{-- AVATAR --}}
            <div class="mb-4 flex justify-center">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}"
                         class="w-28 h-28 rounded-full object-cover border-4 border-blue-600 shadow">
                @else
                    <div class="w-28 h-28 bg-blue-600 text-white rounded-full flex items-center justify-center text-4xl font-bold shadow">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </div>
                @endif
            </div>

            <h2 class="text-lg font-semibold text-gray-800">
                {{ $user->name }}
            </h2>

            <p class="text-sm text-gray-500 mb-3">
                {{ ucfirst($user->role->name ?? '-') }}
            </p>

            {{-- BADGE STATUS --}}
            <span class="px-3 py-1 text-xs rounded-full
                {{ $user->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>

            {{-- UPLOAD AVATAR --}}
            <form action="{{ route('profile.avatar') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="mt-5 space-y-2">
                @csrf

                <input type="file"
                       name="avatar"
                       class="w-full text-sm border rounded-lg p-2">

                <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Update Foto
                </button>
            </form>

        </div>

        {{-- RIGHT PANEL --}}
        <div class="md:col-span-2 space-y-6">

            {{-- ACCOUNT INFORMATION --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">
                    Informasi Akun
                </h3>

                <div class="grid md:grid-cols-2 gap-6 text-sm">

                    <div>
                        <p class="text-gray-500">Nama</p>
                        <p class="font-medium text-gray-800">
                            {{ $user->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium text-gray-800">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Role</p>
                        <p class="font-medium text-gray-800">
                            {{ ucfirst($user->role->name ?? '-') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Status Akun</p>
                        <p class="font-medium text-gray-800">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- EMPLOYEE INFORMATION (ONLY IF EXISTS) --}}
            @if($employee)

                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        Informasi Kepegawaian
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6 text-sm">

                        <div>
                            <p class="text-gray-500">NIK</p>
                            <p class="font-medium text-gray-800">
                                {{ $employee->nik ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Jabatan</p>
                            <p class="font-medium text-gray-800">
                                {{ $employee->jabatan ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Tanggal Masuk</p>
                            <p class="font-medium text-gray-800">
                                {{ $employee->tanggal_masuk ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Jenis Kelamin</p>
                            <p class="font-medium text-gray-800">
                                {{ $employee->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">No HP</p>
                            <p class="font-medium text-gray-800">
                                {{ $employee->no_hp ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Alamat</p>
                            <p class="font-medium text-gray-800">
                                {{ $employee->alamat ?? '-' }}
                            </p>
                        </div>

                    </div>
                </div>

            @endif

        </div>

    </div>

</div>

@endsection
