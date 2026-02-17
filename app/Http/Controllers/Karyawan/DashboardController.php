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
        $employee = Auth::user()->employee;

        $totalHadir = Attendance::where('employee_id', $employee->id)
            ->where('status_hadir', 'pulang')
            ->count();

        $latestPayroll = Payroll::where('employee_id', $employee->id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();

        return view('karyawan.dashboard', compact(
            'employee',
            'totalHadir',
            'latestPayroll'
        ));
    }
}
