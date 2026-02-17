<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $payrolls = Payroll::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $totalGaji = $payrolls->sum('gaji_bersih');
        $totalPotongan = $payrolls->sum('potongan');
        $totalKaryawan = $payrolls->count();

        return view('finance.dashboard', compact(
            'bulan',
            'tahun',
            'payrolls',
            'totalGaji',
            'totalPotongan',
            'totalKaryawan'
        ));
    }
}
