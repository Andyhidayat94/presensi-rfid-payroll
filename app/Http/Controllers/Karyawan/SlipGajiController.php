<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SlipGajiController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;

        $payrolls = Payroll::where('employee_id', $employee->id)
    ->where('status_approval','approved')
    ->orderBy('tahun','desc')
    ->orderBy('bulan','desc')
    ->get();

        return view('karyawan.payroll.index', compact('payrolls'));
    }

    public function download($id)
    {
        $employee = Auth::user()->employee;

        $payroll = Payroll::where('id', $id)
            ->where('employee_id', $employee->id)
            ->firstOrFail();

        $pdf = Pdf::loadView('finance.slip_gaji.pdf', compact('payroll'));

        return $pdf->download(
            'Slip_Gaji_' .
            $payroll->bulan . '_' .
            $payroll->tahun . '.pdf'
        );
    }
}
