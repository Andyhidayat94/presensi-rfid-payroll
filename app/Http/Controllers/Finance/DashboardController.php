<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // =========================
        // AMBIL DATA PAYROLL (SUMBER UTAMA)
        // =========================
        $payrolls = Payroll::with('employee')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $data = [];

        foreach ($payrolls as $p) {

            $data[] = [
                'nama' => $p->employee->nama_lengkap,

                // ✅ FIX ERROR (ini yang tadi hilang)
                'tipe' => $p->tipe_gaji,

                'hadir' => $p->hari_hadir,
                'cuti' => $p->total_cuti ?? 0,
                'sakit' => $p->total_sakit ?? 0,
                'alpha' => $p->total_alpha,

                // breakdown gaji
                'gaji_pokok' => $p->gaji_pokok ?? 0,
                'uang_harian' => $p->upah_harian ?? 0,

                'gaji' => $p->gaji_bersih,
                'status' => $p->status_approval,
            ];
        }

        // =========================
        // SUMMARY
        // =========================
        $totalGaji = $payrolls->sum('gaji_bersih');

        $totalKaryawan = $payrolls->count();

        // indikator masalah
        $karyawanBermasalah = $payrolls->filter(function ($p) {
            return $p->total_alpha > 3;
        })->count();

        return view('finance.dashboard', compact(
            'data',
            'bulan',
            'tahun',
            'totalGaji',
            'totalKaryawan',
            'karyawanBermasalah'
        ));
    }
}