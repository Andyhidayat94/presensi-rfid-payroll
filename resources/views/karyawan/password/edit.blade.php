@extends('layouts.app')

@section('title','Ganti Password')

@section('sidebar')
    <a href="/karyawan/dashboard" class="block px-6 py-3 hover:bg-blue-800">Dashboard</a>
    <a href="/karyawan/attendance" class="block px-6 py-3 hover:bg-blue-800">Presensi Saya</a>
    <a href="/karyawan/payroll" class="block px-6 py-3 hover:bg-blue-800">Slip Gaji</a>
    <a href="/karyawan/password" class="block px-6 py-3 bg-blue-800">Ganti Password</a>
@endsection

@section('content')
<div class="max-w-md bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Ganti Password</h2>

    @if(session('success'))
        <div class="mb-4 text-emerald-600">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/karyawan/password">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-1">Password Baru</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</div>
@endsection
