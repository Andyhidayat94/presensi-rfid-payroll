<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            abort(404, 'Data karyawan tidak ditemukan');
        }

        // =========================
        // TOTAL HADIR
        // =========================
        $totalHadir = Attendance::where('employee_id', $employee->id)
            ->where('status_hadir', 'hadir')
            ->count();

        // =========================
        // GAJI TERAKHIR
        // =========================
        $latestPayroll = Payroll::where('employee_id', $employee->id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();

        return view('karyawan.dashboard', compact(
            'employee',
            'totalHadir',
            'latestPayroll'
        ));
    }
}