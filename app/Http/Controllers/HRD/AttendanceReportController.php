<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceReportController extends Controller
{
    /**
     * ============================
     * REKAP PRESENSI HARIAN
     * ============================
     */
    public function index(Request $request)
    {
        // Default tanggal hari ini
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();

        $attendances = Attendance::with('employee')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        return view('hrd.attendance.index', compact(
            'attendances',
            'tanggal'
        ));
    }

    /**
     * ============================
     * REKAP PRESENSI BULANAN
     * ============================
     */
    public function monthly(Request $request)
    {
        // Default bulan & tahun sekarang
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $attendances = Attendance::with('employee')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get()
            ->groupBy('employee_id');

        return view('hrd.attendance.monthly', compact(
            'attendances',
            'bulan',
            'tahun'
        ));
    }

    /**
     * ============================
     * EXPORT PDF PRESENSI HARIAN
     * ============================
     */
    public function exportPdf(Request $request)
    {
        // Ambil tanggal (wajib)
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();

        $attendances = Attendance::with('employee')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        $pdf = Pdf::loadView(
            'hrd.attendance.pdf',
            compact('attendances', 'tanggal')
        );

        return $pdf->download(
            'rekap-presensi-' . $tanggal . '.pdf'
        );
    }
}
