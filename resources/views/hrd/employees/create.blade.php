@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('breadcrumb')
    <a href="{{ route('hrd.dashboard') }}">HRD</a>
    <span class="mx-2">/</span>
    <a href="{{ route('hrd.employees.index') }}">Data Karyawan</a>
    <span class="mx-2">/</span>
    <span class="text-blue-600 font-medium">Tambah</span>
@endsection

@section('content')

<div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-8">

    <h2 class="text-2xl font-semibold mb-6">Form Tambah Karyawan</h2>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            @foreach ($errors->all() as $error)
                <div>- {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('hrd.employees.store') }}">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <input type="text" name="employee_code" placeholder="Kode Karyawan" required class="border p-2 rounded">
            <input type="email" name="email" placeholder="Email" required class="border p-2 rounded">

            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required class="border p-2 rounded">
            <input type="text" name="nik" placeholder="NIK" required class="border p-2 rounded">

            {{-- POSITION --}}
            <div>
                <label>Jabatan</label>
                <select name="position_id" id="positionSelect" required class="w-full border p-2 rounded">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach($positions as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- DEPARTMENT --}}
            <div>
                <label>Divisi</label>
                <select name="department_id" id="departmentSelect" class="w-full border p-2 rounded">
                    <option value="">-- Tanpa Divisi --</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>

            <input type="date" name="tanggal_masuk" required class="border p-2 rounded">

            <select name="jenis_kelamin" required class="border p-2 rounded">
                <option value="">Jenis Kelamin</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

            <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" required class="border p-2 rounded">
            <input type="date" name="tanggal_lahir" required class="border p-2 rounded">

            <input type="text" name="no_hp" placeholder="No HP" required class="border p-2 rounded">
            <input type="text" name="pendidikan_terakhir" placeholder="Pendidikan" required class="border p-2 rounded">

            <textarea name="alamat" placeholder="Alamat" class="col-span-2 border p-2 rounded"></textarea>

        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('hrd.employees.index') }}" class="px-4 py-2 border rounded">Batal</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        </div>

    </form>
</div>

{{-- SCRIPT AUTO DISABLE --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const position = document.getElementById('positionSelect');
    const dept = document.getElementById('departmentSelect');

    function toggleDept() {
        const text = position.options[position.selectedIndex].text;

        if (text.toLowerCase() === 'direktur') {
            dept.value = '';
            dept.disabled = true;
        } else {
            dept.disabled = false;
        }
    }

    position.addEventListener('change', toggleDept);
    toggleDept();
});
</script>

@endsection