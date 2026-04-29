<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SlipGajiController extends Controller
{
    public function download($id)
{
    $employee = Auth::user()->employee;

    $payroll = Payroll::where('id', $id)
        ->where('employee_id', $employee->id)
        ->firstOrFail();

    $bulan = $payroll->bulan;
    $tahun = $payroll->tahun;

    // =========================
    // HITUNG HARI KERJA
    // =========================
    $start = Carbon::create($tahun, $bulan, 1);
    $end   = $start->copy()->endOfMonth();

    $period = CarbonPeriod::create($start, $end);

    $hariKerja = 0;
    $hariLibur = 0;

    foreach ($period as $date) {
        if ($date->isSunday()) {
            $hariLibur++;
            continue;
        }
        $hariKerja++;
    }

    // =========================
    // HITUNG TOTAL DIBAYAR
    // =========================
    $totalDibayar = $payroll->hari_hadir + $payroll->total_cuti;

    // kalau nanti ada sakit
    $totalDibayar += ($payroll->total_sakit ?? 0);

    $pdf = Pdf::loadView('karyawan.slip_gaji.pdf', compact(
        'payroll',
        'hariKerja',
        'hariLibur',
        'totalDibayar'
    ));

    return $pdf->download(
        'Slip_Gaji_' . $payroll->bulan . '_' . $payroll->tahun . '.pdf'
    );
}
}
