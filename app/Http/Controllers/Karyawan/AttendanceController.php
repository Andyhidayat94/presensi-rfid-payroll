<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $employee = Auth::user()->employee;

        $month = $request->month ?? date('m');
        $year  = $request->year ?? date('Y');

        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('karyawan.attendance.index', compact(
            'attendances',
            'month',
            'year'
        ));
    }
}
