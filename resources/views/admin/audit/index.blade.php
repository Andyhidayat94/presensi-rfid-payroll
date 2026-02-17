@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold">Audit Log</h1>
        <p class="text-sm text-gray-500">Semua aktivitas sistem</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <table class="w-full text-sm">
            <thead class="border-b text-left">
                <tr>
                    <th>User</th>
                    <th>Module</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="border-b hover:bg-gray-50">
                    <td>{{ $log->user->name }}</td>
                    <td>{{ ucfirst($log->module) }}</td>
                    <td>
                        <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-600">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>

</div>

@endsection
