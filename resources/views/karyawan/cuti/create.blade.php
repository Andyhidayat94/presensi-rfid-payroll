@extends('layouts.app')

@section('breadcrumb')
    <a href="/karyawan/dashboard" class="hover:text-blue-600">Dashboard</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Pengajuan Cuti</span>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Ajukan Cuti</span>
@endsection

@section('content')

<div class="max-w-2xl mx-auto">

    <h2 class="text-2xl font-semibold mb-6">
        Ajukan Cuti / Sakit
    </h2>

    <div class="bg-white rounded-xl shadow p-6">

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('karyawan.cuti.store') }}"
              class="space-y-4">

            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">
                    Jenis Izin
                </label>
                <select name="jenis_izin"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih --</option>
                    <option value="cuti">Cuti</option>
                    <option value="sakit">Sakit</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Tanggal Mulai
                    </label>
                    <input type="date"
                           name="tanggal_mulai"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Tanggal Selesai
                    </label>
                    <input type="date"
                           name="tanggal_selesai"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Keterangan
                </label>
                <textarea name="keterangan"
                          rows="3"
                          class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                          placeholder="Jelaskan alasan..."></textarea>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 rounded-lg shadow transition">
                    Kirim Pengajuan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
