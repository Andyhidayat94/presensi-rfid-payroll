@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Tambah Setting Gaji</h1>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">

        <form action="{{ route('finance.salary.store') }}" method="POST">
            @csrf

            {{-- JABATAN --}}
            <div class="mb-4">
                <label class="text-sm text-gray-600">Jabatan</label>
                <select name="position_id" required
                    class="w-full mt-1 border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach($positions as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- DIVISI --}}
            <div class="mb-4">
                <label class="text-sm text-gray-600">Divisi</label>
                <select name="department_id"
                    class="w-full mt-1 border rounded-lg px-3 py-2">
                    <option value="">-- Tanpa Divisi (Direktur) --</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- TIPE GAJI --}}
            <div class="mb-4">
                <label class="text-sm text-gray-600">Tipe Gaji</label>
                <select name="tipe_gaji" id="tipe_gaji" required
                    class="w-full mt-1 border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Tipe Gaji --</option>
                    <option value="harian">Harian</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>

            {{-- GAJI POKOK --}}
            <div id="gaji_pokok_group" class="mb-4">
                <label class="text-sm text-gray-600">Gaji Pokok</label>
                <input type="number" name="gaji_pokok"
                    class="w-full mt-1 border rounded-lg px-3 py-2"
                    placeholder="Contoh: 5000000">
            </div>

            {{-- UPAH HARIAN --}}
            <div id="upah_harian_group" class="mb-4">
                <label class="text-sm text-gray-600">Upah Harian</label>
                <input type="number" name="upah_harian"
                    class="w-full mt-1 border rounded-lg px-3 py-2"
                    placeholder="Contoh: 100000">
            </div>

            {{-- POTONGAN ALPHA --}}
            <div id="potongan_group" class="mb-4">
                <label class="text-sm text-gray-600">Potongan Alpha / Hari</label>
                <input type="number" name="potongan_alpha"
                    class="w-full mt-1 border rounded-lg px-3 py-2"
                    placeholder="Contoh: 150000">
            </div>

            {{-- BUTTON --}}
            <div class="mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

{{-- SCRIPT TOGGLE --}}
<script>
const tipe = document.getElementById('tipe_gaji');

const gajiPokok = document.getElementById('gaji_pokok_group');
const upahHarian = document.getElementById('upah_harian_group');
const potongan = document.getElementById('potongan_group');

function toggleGaji() {

    if (tipe.value === 'harian') {

        gajiPokok.style.display = 'none';
        potongan.style.display = 'none';
        upahHarian.style.display = 'block';

    } else if (tipe.value === 'bulanan') {

        gajiPokok.style.display = 'block';
        potongan.style.display = 'block';
        upahHarian.style.display = 'none';

    } else {

        gajiPokok.style.display = 'none';
        potongan.style.display = 'none';
        upahHarian.style.display = 'none';
    }
}

tipe.addEventListener('change', toggleGaji);
window.onload = toggleGaji;
</script>

@endsection