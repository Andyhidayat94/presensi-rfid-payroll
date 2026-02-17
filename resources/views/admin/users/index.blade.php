@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold">Manajemen User</h1>
        <p class="text-gray-500 text-sm">Kelola semua akun sistem</p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-4">Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
@foreach($users as $user)
<tr class="border-t hover:bg-gray-50 transition">
    <td class="p-4 font-medium text-gray-800">
        {{ $user->name }}
    </td>

    <td class="text-gray-600">
        {{ $user->email }}
    </td>

    <td>
        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
            {{ ucfirst($user->role->name ?? '-') }}
        </span>
    </td>

    <td>
        <span class="px-3 py-1 rounded-full text-xs font-semibold
            {{ $user->is_active 
                ? 'bg-green-100 text-green-700' 
                : 'bg-red-100 text-red-600' }}">
            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
        </span>
    </td>

    <td class="text-center">

        @php
            $isSelf = $user->id === auth()->id();
            $isAdmin = $user->role->name === 'admin';
            $activeAdminCount = \App\Models\User::whereHas('role', function($q){
                $q->where('name','admin');
            })->where('is_active',1)->count();
        @endphp

        @if($isSelf)
            <span class="text-gray-400 text-xs">Tidak bisa ubah akun sendiri</span>

        @elseif($isAdmin && $activeAdminCount <= 1)
            <span class="text-gray-400 text-xs">Admin terakhir (Protected)</span>

        @else
            <form method="POST"
                  action="{{ route('admin.users.toggle',$user->id) }}">
                @csrf

                <button class="px-4 py-1.5 text-xs rounded-full font-medium
                    transition shadow-sm
                    {{ $user->is_active 
                        ? 'bg-red-500 hover:bg-red-600 text-white'
                        : 'bg-green-600 hover:bg-green-700 text-white' }}">
                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        @endif

    </td>
</tr>
@endforeach
</tbody>

        </table>

    </div>

</div>

@endsection
