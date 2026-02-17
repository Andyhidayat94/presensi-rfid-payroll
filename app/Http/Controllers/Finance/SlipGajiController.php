<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

class SlipGajiController extends Controller
{
    public function download($id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);

        $pdf = Pdf::loadView('finance.slip_gaji.pdf', compact('payroll'));

        return $pdf->download(
            'Slip_Gaji_' .
            $payroll->employee->nama_lengkap . '_' .
            $payroll->bulan . '_' .
            $payroll->tahun . '.pdf'
        );
    }
}
