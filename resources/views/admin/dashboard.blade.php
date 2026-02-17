@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-sm text-gray-500">System control & approval management</p>
    </div>

    <!-- KPI CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">Total User</p>
            <p class="text-3xl font-bold text-blue-600">
                {{ $totalUser ?? 0 }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500">
            <p class="text-sm text-gray-500">User Aktif</p>
            <p class="text-3xl font-bold text-green-600">
                {{ $userAktif ?? 0 }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500">Pending Leave</p>
            <p class="text-3xl font-bold text-yellow-600">
                {{ $pendingLeave ?? 0 }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Pending Payroll</p>
            <p class="text-3xl font-bold text-red-600">
                {{ $pendingPayroll ?? 0 }}
            </p>
        </div>

    </div>

    <!-- APPROVAL CHART -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-semibold text-gray-700 mb-4">
            Approval Activity (30 Hari)
        </h2>
        <canvas id="approvalChart" height="100"></canvas>
    </div>

    <!-- PAYROLL CHART -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-semibold text-gray-700 mb-4">
            Total Payroll 12 Bulan Terakhir
        </h2>
        <canvas id="payrollChart" height="100"></canvas>
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="font-semibold text-gray-700 mb-4">
            Recent Leave Requests
        </h2>

        <table class="w-full text-sm">
            <thead class="border-b text-left">
                <tr>
                    <th class="py-2">Nama</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLeaves ?? [] as $leave)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2">
                        {{ $leave->employee->nama_lengkap ?? '-' }}
                    </td>
                    <td>
                        {{ ucfirst($leave->jenis_izin ?? '-') }}
                    </td>
                    <td>
                        <span class="px-3 py-1 rounded-full text-xs
                            @if(($leave->status ?? '') == 'pending')
                                bg-yellow-100 text-yellow-600
                            @elseif(($leave->status ?? '') == 'disetujui')
                                bg-green-100 text-green-600
                            @else
                                bg-red-100 text-red-600
                            @endif
                        ">
                            {{ ucfirst($leave->status ?? '-') }}
                        </span>
                    </td>
                    <td>
                        {{ optional($leave->created_at)->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-6 text-center text-gray-400">
                        Belum ada aktivitas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // =============================
    // Approval Chart
    // =============================
    const approvalCtx = document.getElementById('approvalChart');

    if (approvalCtx) {
        new Chart(approvalCtx, {
            type: 'line',
            data: {
                labels: @json($last30Days ?? []),
                datasets: [{
                    label: 'Approved Leaves',
                    data: @json($approvalData ?? []),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    // =============================
    // Payroll Chart
    // =============================
    const payrollCtx = document.getElementById('payrollChart');

    if (payrollCtx) {
        new Chart(payrollCtx, {
            type: 'bar',
            data: {
                labels: @json($payrollLabels ?? []),
                datasets: [{
                    label: 'Total Gaji',
                    data: @json($payrollData ?? []),
                    backgroundColor: '#16a34a'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
</script>

@endsection
