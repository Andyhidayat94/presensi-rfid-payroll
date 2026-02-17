<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\SalarySetting;
use Carbon\Carbon;

class PayrollController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX – Daftar payroll
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('finance.payroll.index', compact('payrolls'));
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE PAYROLL BULANAN
    |--------------------------------------------------------------------------
    */
    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric|min:2024',
        ]);

        $month = $request->bulan;
        $year  = $request->tahun;

        $employees = Employee::all();

        foreach ($employees as $employee) {

            /*
            |--------------------------------------------------------------------------
            | CEK JIKA PAYROLL SUDAH LOCKED
            |--------------------------------------------------------------------------
            */
            $existingPayroll = Payroll::where('employee_id', $employee->id)
                ->where('bulan', $month)
                ->where('tahun', $year)
                ->first();

            if ($existingPayroll && $existingPayroll->locked) {
                continue; // lewati jika sudah dikunci
            }

            /*
            |--------------------------------------------------------------------------
            | AMBIL UPAH HARIAN BERDASARKAN JABATAN
            |--------------------------------------------------------------------------
            */
            $setting = SalarySetting::where('jabatan', $employee->jabatan)->first();

            if (!$setting) {
                continue; // kalau belum ada setting jabatan, skip
            }

            $upahHarian = $setting->upah_harian;

            /*
            |--------------------------------------------------------------------------
            | HITUNG HARI DIBAYAR (pulang + cuti + sakit)
            |--------------------------------------------------------------------------
            */
            $hariDibayar = Attendance::where('employee_id', $employee->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->whereIn('status_hadir', ['pulang', 'cuti', 'sakit'])
                ->count();

            /*
            |--------------------------------------------------------------------------
            | HITUNG ALPHA
            |--------------------------------------------------------------------------
            */
            $hariAlpha = Attendance::where('employee_id', $employee->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->where('status_hadir', 'alpha')
                ->count();

            /*
            |--------------------------------------------------------------------------
            | PERHITUNGAN GAJI MODEL TOKO
            | Masuk dibayar, tidak masuk tidak dibayar
            |--------------------------------------------------------------------------
            */
            $gajiPokok  = $hariDibayar * $upahHarian;
            $potongan   = $hariAlpha * $upahHarian;
            $gajiBersih = $gajiPokok - $potongan;

            /*
            |--------------------------------------------------------------------------
            | SIMPAN / UPDATE
            |--------------------------------------------------------------------------
            */
            Payroll::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'bulan' => $month,
                    'tahun' => $year,
                ],
                [
                    'hari_hadir' => $hariDibayar,
                    'gaji_pokok' => $gajiPokok,
                    'potongan'   => $potongan,
                    'gaji_bersih'=> $gajiBersih,
                    'status_approval' => 'pending',
                    'locked' => false
                ]
            );
        }

        return back()->with('success', 'Payroll berhasil digenerate.');
    }


    /*
    |--------------------------------------------------------------------------
    | HISTORY PAYROLL PER BULAN
    |--------------------------------------------------------------------------
    */
    public function history()
    {
        $data = Payroll::selectRaw('bulan, tahun,
                SUM(gaji_bersih) as total_gaji,
                SUM(potongan) as total_potongan,
                COUNT(*) as total_karyawan')
            ->groupBy('bulan','tahun')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();

        return view('finance.payroll.history', compact('data'));
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD SLIP
    |--------------------------------------------------------------------------
    */
    public function downloadSlip($id)
    {
        $payroll = Payroll::with('employee')->findOrFail($id);

        $month = $payroll->bulan;
        $year  = $payroll->tahun;
        $employeeId = $payroll->employee_id;

        $hadir = Attendance::where('employee_id', $employeeId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status_hadir', 'pulang')
            ->count();

        $cuti = Attendance::where('employee_id', $employeeId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status_hadir', 'cuti')
            ->count();

        $sakit = Attendance::where('employee_id', $employeeId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status_hadir', 'sakit')
            ->count();

        $alpha = Attendance::where('employee_id', $employeeId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->where('status_hadir', 'alpha')
            ->count();

        $upahHarian = $payroll->hari_hadir > 0
            ? $payroll->gaji_pokok / $payroll->hari_hadir
            : 0;

        $pdf = \PDF::loadView('finance.payroll.slip', compact(
            'payroll',
            'hadir',
            'cuti',
            'sakit',
            'alpha',
            'upahHarian'
        ));

        return $pdf->download(
            'Slip_Gaji_' . $payroll->employee->nama_lengkap . '.pdf'
        );
    }
}
