<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SlipGajiController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;

        $payrolls = Payroll::where('employee_id', $employee->id)
            ->where('status_approval', 'approved')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return view('karyawan.payroll.index', compact('payrolls'));
    }

    public function download($id)
    {
        $employee = Auth::user()->employee;

        $payroll = Payroll::where('id', $id)
            ->where('employee_id', $employee->id)
            ->firstOrFail();

        $bulan = $payroll->bulan;
        $tahun = $payroll->tahun;

        // =========================
        // HITUNG HARI KERJA (SAMA DENGAN PAYROLL)
        // =========================
        $start = Carbon::create($tahun, $bulan, 1);
        $end   = $start->copy()->endOfMonth();

        $period = CarbonPeriod::create($start, $end);

        $hariKerja = 0;
        $hariLibur = 0;

        // ⚠️ HARUS SAMA DENGAN PAYROLL CONTROLLER
        $tanggalMerah = [
            $start->copy()->day(18)->format('Y-m-d'),
            $start->copy()->day(25)->format('Y-m-d'),
        ];

        foreach ($period as $date) {

            if ($date->isSunday()) {
                $hariLibur++;
                continue;
            }

            if (in_array($date->format('Y-m-d'), $tanggalMerah)) {
                $hariLibur++;
                continue;
            }

            $hariKerja++;
        }

        // =========================
        // AMBIL DATA AKTIVITAS
        // =========================
        $hadir = $payroll->hari_hadir;
        $cuti  = $payroll->total_cuti;
        $alpha = $payroll->total_alpha;
        $sakit = $payroll->total_sakit ?? 0;

        // =========================
        // VALIDASI BIAR TIDAK LEBIH DARI HARI KERJA
        // =========================
        $totalAktivitas = $hadir + $cuti + $sakit + $alpha;

        if ($totalAktivitas > $hariKerja) {
            $alpha = max(0, $hariKerja - ($hadir + $cuti + $sakit));
        }

        // =========================
        // TOTAL DIBAYAR
        // =========================
        $totalDibayar = $hadir + $cuti + $sakit;

        // =========================
        // LOAD PDF
        // =========================
        $pdf = Pdf::loadView('karyawan.slip_gaji.pdf', compact(
            'payroll',
            'hariKerja',
            'hariLibur',
            'hadir',
            'cuti',
            'sakit',
            'alpha',
            'totalDibayar'
        ));

        return $pdf->download(
            'Slip_Gaji_' . $bulan . '_' . $tahun . '.pdf'
        );
    }
}