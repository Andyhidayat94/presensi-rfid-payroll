<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST DATA ABSENSI
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | TAP ABSENSI (MASUK & PULANG)
    |--------------------------------------------------------------------------
    */
    public function tap()
    {
        $employee = Auth::user()->employee;
        $today = Carbon::today();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('tanggal', $today)
            ->first();

        // =========================
        // TAP MASUK
        // =========================
        if (!$attendance) {

            Attendance::create([
                'employee_id' => $employee->id,
                'tanggal' => $today,
                'jam_masuk' => now(),
                'status_hadir' => 'hadir'
            ]);

            return back()->with('success', 'Absen masuk berhasil');
        }

        // =========================
        // TAP PULANG
        // =========================
        if (!$attendance->jam_pulang) {

            $attendance->update([
                'jam_pulang' => now()
            ]);

            return back()->with('success', 'Absen pulang berhasil');
        }

        // =========================
        // SUDAH ABSEN
        // =========================
        return back()->with('error', 'Kamu sudah absen hari ini');
    }
}